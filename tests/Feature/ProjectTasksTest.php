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

    public function test_task_requires_a_body()
    {
        $this->signIn();
        $project = Project::factory()
            ->for(auth()->user(), 'owner')
            ->create();

        $this->post("/projects/{$project->id}/tasks", ['body' => ''])
            ->assertSessionHasErrors('body');

    }
}
