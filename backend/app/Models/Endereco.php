<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep'
    ];

    /**
     * Um endereço pode pertencer a vários usuários (muitos-para-muitos).
     */
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'endereco_usuario');
    }
}
