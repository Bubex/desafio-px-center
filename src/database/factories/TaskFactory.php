<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Pendente', 'Em Andamento', 'Concluída']),
            'priority' => $this->faker->randomElement(['Baixa', 'Média', 'Alta']),
            'deadline' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
