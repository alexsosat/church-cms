<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "status" => $this->faker->numberBetween(0, 2),
            "is_baptized" => $this->faker->boolean(),
            "baptized_date" => $this->faker->date(),
            "user_id" => $this->faker->numberBetween(2, 4),
        ];

    }
}
