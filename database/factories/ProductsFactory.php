<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorys = ['React','Vue','Laravel'];
        return [
            'title' => $this -> faker -> realtext(12),
            'content' => $this -> faker -> realtext(20),
            'category' => $this -> $faker -> randomElement($categorys)
        ];
    }
}