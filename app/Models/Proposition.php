<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $table = 'propositions';
    protected $primaryKey = 'id_proposition';

    protected $fillable = [
        'partie_id',
        'joueur_id',
        'num_tour',
        'combinaison',
        'chiffre_correct',
    ];

    public function showPartie()
    {
        return $this->belongsTo(Partie::class, 'partie_id');
    }

    public function showJoueur()
    {
        return $this->belongsTo(User::class, 'joueur_id');
    }


}
