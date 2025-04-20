<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'done', 'canceled']),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
