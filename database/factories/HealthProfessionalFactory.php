<?php

namespace Database\Factories;

use App\Enums\ProfessionalTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthProfessional>
 */
class HealthProfessionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'type' => $this->faker->randomElement(array_map(fn ($e) => $e->value, ProfessionalTypeEnum::cases())),
        ];
    }
}
