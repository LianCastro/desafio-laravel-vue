<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';
    protected $fillable = ['nome'];

    /**
     * Um perfil pode ter vários usuários.
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}
