<?php

namespace Modules\Lottery\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Lottery\Models\Lottery;

class LotteryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Lottery::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Uso company para nombres más apropiados de loterías
            'description' => $this->faker->paragraph(2), // Genera una descripción de 2 párrafos
            'url_imagen' => $this->faker->imageUrl(640, 480, 'lottery'),
        ];
    }
}



