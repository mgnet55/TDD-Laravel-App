<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_have_tasks()
    {
        $this->signIn();
        $project = Project::factory()
            ->for(auth()->user(), 'owner')
            ->create();

        $this->post("/projects/{$project->id}/tasks", ['body' => 'test task body']);
        $this->get("/projects/{$project->id}")
            ->assertSee('test task body');

    }

    public function test_task_can_be_updated()
    {
        $this->signIn();
        $project = Project::factory()
            ->for(auth()->user(), 'owner')
            ->create();

        $task = $project->addTask('test task');

        $this->patch("/projects/{$project->id}/tasks/{$task->id}", ['body' => 'changed task', 'completed' => true]);
        $this->get("/projects/{$project->id}")
            ->assertSee('changed task')
            ->assertDontSee('task task');

        $this->assertDatabaseHas('tasks', ['body' => 'changed task', 'completed' => true]);

    }

    public function test_task_requires_a_body()
    {
        $this->signIn();
        $project = Project::factory()
            ->for(auth()->user(), 'owner')
            ->create();

        $this->post("/projects/{$project->id}/tasks", ['body' => ''])
            ->assertSessionHasErrors('body');

    }

    public function test_only_the_owner_of_a_project_may_add_task()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->post("/projects/{$project->id}/tasks", ['body' => 'only owner can do this'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'only owner can do this']);

    }

    public function test_only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project = Project::factory()->create();
        $task = $project->addTask('task');

        $this->patch("/projects/{$project->id}/tasks/{$task->id}", ['body' => 'updated'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);

    }
}
