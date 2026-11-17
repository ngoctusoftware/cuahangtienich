<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'contact_name' => fake()->name(),
            'phone' => fake()->numerify('09########'),
            'email' => fake()->safeEmail(),
            'address' => fake()->address(),
            'notes' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
