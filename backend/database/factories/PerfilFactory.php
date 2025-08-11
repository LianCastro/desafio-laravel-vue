<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->randomElement([
                'Administrador',
                'Usuário',
                'Gerente'
            ])
        ];
    }
}
