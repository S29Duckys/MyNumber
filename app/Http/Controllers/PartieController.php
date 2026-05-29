<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('game.afficher', ['partie' => $partie]);
    }
}
