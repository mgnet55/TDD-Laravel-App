<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserTest extends TestCase
{
    use refreshDatabase;

    public function test_task_belongs_to_project()
    {
        $task = Task::factory()->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }
}
