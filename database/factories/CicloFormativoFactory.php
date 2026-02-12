<?php

namespace Database\Factories;

use App\Models\FamiliaProfesional;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CicloFormativoFactory extends Factory
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
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        /*
            ''familia_profesional_id',
            'nombre',
            'codigo',
            'grado',
            'descripcion',
        */

        return [
            'familia_profesional_id' => FamiliaProfesional::factory(),
            'nombre' => $this->faker->words(3, true),
            'codigo' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'grado' => $this->faker->randomElement(['basico', 'medio', 'superior']),
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
