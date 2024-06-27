<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Workspace;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Workspace::factory(50)->create();

        $users = User::all();
        $workspaces = Workspace::all();
        foreach ($workspaces as $workspace) {
            $workspace->users()->attach($users->random(rand(1, 3))->pluck('id')->toArray());
        }
        Task::factory(150)->create();

    }
}
