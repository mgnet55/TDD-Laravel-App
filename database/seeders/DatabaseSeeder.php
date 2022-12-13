<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(10)->hasProjects(3)->create();

        User::factory()
            ->has(Project::factory(6)->hasTasks(5))
            ->create(['email' => 'user@example.com', 'name' => 'John Doe']);

        $this->command->table(['Email', 'Password'], [['user@example.com', 'password']]);

    }
}
