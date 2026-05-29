<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    protected $table = 'parties';
    protected $primaryKey = 'id_partie';

    protected $fillable = [
        'token_invitation',
        'createur_id',
        'adversaire_id',
        'gagnant_id',
        'tour_joueur_id',
        'statut',
    ];

    public function showCreateur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    public function showAdversaire()
    {
        return $this->belongsTo(User::class, 'adversaire_id');
    }

    public function showGagnant()
    {
        return $this->belongsTo(User::class, 'gagnant_id');
    }

    public function showTourJoueur()
    {
        return $this->belongsTo(User::class, 'tour_joueur_id');
    }

    public function showCombinaisons()
    {
        return $this->hasMany(CombinaisonSecret::class, 'partie_id');
    }

    public function showPropositions()
    {
        return $this->hasMany(Proposition::class, 'partie_id');
    }
}
