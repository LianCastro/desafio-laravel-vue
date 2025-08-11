<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perfil;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar 3 perfis (um de cada tipo)
        collect(['Administrador', 'Usuário', 'Gerente'])
            ->each(fn ($nome) => Perfil::create(['nome' => $nome]));
    }
}
