<?php

namespace Database\Factories;

use App\Models\Workspace;
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
        $workspaceId = rand(1, 50);
        $members = Workspace::find($workspaceId)->users->pluck('id')->toArray();

        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'workspace_id' => $workspaceId,
            'createdBy' => $members[array_rand($members)],
            'assignedTo' => $members[array_rand($members)],
            'due_date' => fake()->dateTimeBetween(now(), '+1 week'),
        ];
    }
}
