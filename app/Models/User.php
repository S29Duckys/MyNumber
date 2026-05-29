<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Les hasMany : toutes les tables qui pointent vers users

    public function showPartiesCreees()
    {
        return $this->hasMany(Partie::class, 'createur_id');
    }

    public function showPropositions()
    {
        return $this->hasMany(Proposition::class, 'joueur_id');
    }

    public function showCombinaisons()
    {
        return $this->hasMany(CombinaisonSecret::class, 'joueur_id');
    }
}
