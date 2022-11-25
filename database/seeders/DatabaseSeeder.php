<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
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

        \App\Models\User::factory(10)->hasProjects(3)->create();

        $user = \App\Models\User::factory()
            ->has(Project::factory(5)
                ->has(Task::factory(4), 'tasks'),
                'projects')
            ->create(['email' => 'user@example.com']);

        $this->command->table(
            ['Email', 'Password'],
            [[$user->email, 'password']]
        );

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
