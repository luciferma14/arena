<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    protected $model = Evento::class;

    public function definition(): array
    {
        return [
            'nombre'            => fake()->sentence(3),
            'descripcion_corta' => fake()->sentence(8),
            'descripcion_larga' => fake()->paragraph(3),
            'poster_url'        => fake()->imageUrl(640, 480, 'events'),
            'fecha'             => fake()->unique()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'hora'              => fake()->time('H:i'),
        ];
    }
}
