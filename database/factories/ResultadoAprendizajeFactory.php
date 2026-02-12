<?php

namespace Database\Factories;

use App\Models\ModuloFormativo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResultadoAprendizaje>
 */
class ResultadoAprendizajeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'modulo_formativo_id' => ModuloFormativo::factory(),
            'codigo' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'descripcion' => $this->faker->paragraph(),
            'peso_porcentaje' => $this->faker->randomFloat(2, 0, 100),
            'orden' => $this->faker->numberBetween(1, 100)
        ];
    }
}
