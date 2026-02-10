<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ModuloFormativoFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */

    /*
    protected static ?string $password;
    */

    /**
     * Define the model's default state.
     *
     *
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        /*

        'ciclo_formativo_id',
        'nombre',
        'codigo',
        'horas_totales',
        'curso_escolar',
        'centro',
        'docente_id',
        'descripcion',

        */


        return [
            'ciclo_formativo_id' => fake()->name(),
            'nombre' => fake()->name(),
            'codigo' => fake()->name(),
            'horas_totales' => fake()->name(),
            'curso_escolar' => fake()->name(),
            'centro' => fake()->name(),
            'docente_id' => fake()->name(),
            'descripcion' => fake()->name()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

    /*
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
        */
}
