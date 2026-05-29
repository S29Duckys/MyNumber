<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partie;
use App\Models\CombinaisonSecret;
use App\Models\Proposition;
use Illuminate\Support\Str;

class PartieController extends Controller
{
    public function createPartie()
    {
        $partie = Partie::create([
            'token_invitation' => Str::uuid(),
            'createur_id'      => auth()->id(),
            'statut'           => 'en_attente',
        ]);

        return redirect()->route('game.afficher', $partie->token_invitation);
    }

    public function showPartie($token)
    {
        $partie = Partie::where('token_invitation', $token)->firstOrFail();

        $aDejaSubmis = $partie->statut === 'preparation'
            && $partie->combinaisons()->where('joueur_id', auth()->id())->exists();

        return view('game.afficher', compact('partie', 'aDejaSubmis'));
    }

    // Étape 1 — rejoindre
    public function rejoindrePartie($token)
    {
        $partie = Partie::where('token_invitation', $token)->firstOrFail();

        abort_if($partie->statut !== 'en_attente', 403);
        abort_if($partie->createur_id == auth()->id(), 403, 'Tu es déjà le créateur.');

        $partie->update([
            'adversaire_id' => auth()->id(),
            'statut'        => 'preparation',
        ]);

        return redirect()->route('game.afficher', $token);
    }

    // Étape 2 — soumettre sa combinaison secrète
    public function soumettreCombinaison(Request $request, $token)
    {
        $request->validate([
            'combinaison' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ]);

        $partie = Partie::where('token_invitation', $token)->firstOrFail();

        abort_if($partie->statut !== 'preparation', 403);
        abort_if(
            $partie->createur_id != auth()->id() && $partie->adversaire_id != auth()->id(),
            403
        );

        // Déjà soumis
        if ($partie->combinaisons()->where('joueur_id', auth()->id())->exists()) {
            return redirect()->route('game.afficher', $token);
        }

        CombinaisonSecret::create([
            'partie_id'   => $partie->id_partie,
            'joueur_id'   => auth()->id(),
            'combinaison' => $request->combinaison,
        ]);

        // Les deux joueurs ont soumis → on démarre
        if ($partie->combinaisons()->count() === 2) {
            $partie->update([
                'statut'         => 'en_cours',
                'tour_joueur_id' => $partie->createur_id,
            ]);
        }

        return redirect()->route('game.afficher', $token);
    }

    // Étape 3 & 4 — soumettre une proposition + vérifier victoire
    public function soumettreProposition(Request $request, $token)
    {
        $request->validate([
            'combinaison' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ]);

        $partie = Partie::where('token_invitation', $token)->firstOrFail();

        abort_if($partie->statut !== 'en_cours', 403);
        abort_if($partie->tour_joueur_id != auth()->id(), 403, "Ce n'est pas ton tour.");

        // Combinaison secrète de l'adversaire
        $adversaireId = $partie->createur_id == auth()->id()
            ? $partie->adversaire_id
            : $partie->createur_id;

        $secret = $partie->combinaisons()
            ->where('joueur_id', $adversaireId)
            ->value('combinaison');

        // Calcul des chiffres corrects (correspondance exacte par position)
        $guess = $request->combinaison;
        $chiffreCorrect = 0;
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $secret[$i]) {
                $chiffreCorrect++;
            }
        }

        $numTour = $partie->propositions()->where('joueur_id', auth()->id())->count() + 1;

        Proposition::create([
            'partie_id'       => $partie->id_partie,
            'joueur_id'       => auth()->id(),
            'num_tour'        => $numTour,
            'combinaison'     => $guess,
            'chiffre_correct' => $chiffreCorrect,
        ]);

        // Victoire
        if ($chiffreCorrect === 4) {
            $partie->update([
                'gagnant_id' => auth()->id(),
                'statut'     => 'terminee',
            ]);
        } else {
            // Passer le tour à l'adversaire
            $partie->update(['tour_joueur_id' => $adversaireId]);
        }

        return redirect()->route('game.afficher', $token);
    }
}
