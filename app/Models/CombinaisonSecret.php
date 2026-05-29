<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CombinaisonSecret extends Model
{
    protected $table = 'combinaison_secret';
    protected $primaryKey = 'id_combinaison';
    const UPDATED_AT = null;

    protected $fillable = [
        'partie_id',
        'joueur_id',
        'combinaison',
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
