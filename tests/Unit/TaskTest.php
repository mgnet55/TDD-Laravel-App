<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_belongs_to_project()
    {
        $task = Task::factory()->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_task_can_be_completed()
    {
        $task = Task::factory()->create(['completed' => false]);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    public function test_task_can_be_incomplete()
    {
        $task = Task::factory()->create(['completed' => true]);
        
        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
