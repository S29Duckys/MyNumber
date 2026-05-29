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

    public function createur()
    {
        return $this->belongsTo(User::class, 'createur_id', 'id_user');
    }

    public function adversaire()
    {
        return $this->belongsTo(User::class, 'adversaire_id', 'id_user');
    }

    public function gagnant()
    {
        return $this->belongsTo(User::class, 'gagnant_id', 'id_user');
    }

    public function tourJoueur()
    {
        return $this->belongsTo(User::class, 'tour_joueur_id', 'id_user');
    }

    public function combinaisons()
    {
        return $this->hasMany(CombinaisonSecret::class, 'partie_id', 'id_partie');
    }

    public function propositions()
    {
        return $this->hasMany(Proposition::class, 'partie_id', 'id_partie');
    }
}
