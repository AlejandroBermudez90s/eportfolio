<?php

namespace Database\Factories;

use App\Models\CicloFormativo;
use App\Models\User;
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
            'ciclo_formativo_id' => CicloFormativo::factory(),
            'nombre' => $this->faker->words(3, true),
            'codigo' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'horas_totales' => $this->faker->numberBetween(20, 200),
            'curso_escolar' => $this->faker->words(3, true),
            'centro' => $this->faker->words(3, true),
            'docente_id' => User::factory(),
            'descripcion' => $this->faker->paragraph()
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
