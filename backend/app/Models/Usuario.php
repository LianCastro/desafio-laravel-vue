<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'cpf', 'perfil_id'];

    /**
     * Um usuário pertence a um perfil.
     */
    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    /**
     * Um usuário pode ter vários endereços.
     */
    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'endereco_usuario');
    }
}
