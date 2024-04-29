<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pdfdoc;
use App\Models\TextData;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TextVector>
 */
class TextVectorFactory extends Factory
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
            'vector' => fake()->sentence(45),
            'text_id' => TextData::factory(),
            'file_id' => Pdfdoc::factory(),
        ];
    }
}
