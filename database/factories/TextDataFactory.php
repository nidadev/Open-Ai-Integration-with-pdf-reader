<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pdfdoc;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TextData>
 */
class TextDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'text' => fake()->name(),
            'file_id' => Pdfdoc::factory(),
        ];
    }
}
