<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CombinaisonSecret extends Model
{
    protected $table = 'combinaison_secret';
    protected $primaryKey = 'id_combinaison';

    protected $fillable = [
        'partie_id',
        'joueur_id',
        'combinaison',
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
