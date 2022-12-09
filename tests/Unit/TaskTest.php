<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_task_can_be_completed()
    {
        $this->withoutExceptionHandling();
        $task = Task::factory()->create();

        $this->assertFalse($task->fresh()->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    public function test_task_can_be_incomplete()
    {
        $this->withoutExceptionHandling();
        $task = Task::factory()->create(['completed' => true]);

        $this->assertTrue($task->fresh()->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
