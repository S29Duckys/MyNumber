<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $table = 'proposition';
    protected $primaryKey = 'id_proposition';
    const UPDATED_AT = null;

    protected $fillable = [
        'partie_id',
        'joueur_id',
        'num_tour',
        'combinaison',
        'chiffre_correct',
    ];

    public function partie()
    {
        return $this->belongsTo(Partie::class, 'partie_id', 'id_partie');
    }

    public function joueur()
    {
        return $this->belongsTo(User::class, 'joueur_id', 'id_user');
    }


}
