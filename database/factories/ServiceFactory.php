<?php

namespace Database\Factories;

use App\Enums\ServiceTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(8),
            'type' => $this->faker->randomElement(array_map(fn ($e) => $e->value, ServiceTypeEnum::cases())),
        ];
    }
}
