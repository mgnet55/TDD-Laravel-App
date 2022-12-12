<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProjectTest extends TestCase
{
    use refreshDatabase;

    public function test_project_belongs_to_user()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);

    }

    public function test_project_can_add_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();
        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));

    }
}
