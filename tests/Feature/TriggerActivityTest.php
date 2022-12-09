<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_createing_project()
    {
        $project = Project::factory()->create();
        $this->assertCount(1, $project->activity);

        tap($project->activity->first(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    public function test_updating_project()
    {
        $project = Project::factory()->create();
        $originalTitle = $project->title;
        $project->update(['title' => 'updated title']);
        $this->assertCount(2, $project->activity);

        tap($project->activity->first(), function ($activity) use ($originalTitle) {

            $this->assertEquals('updated_project', $activity->description);

            $this->assertEquals([
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'updated title'],
            ],
                $activity->changes);
        });
    }

    public function test_creating_a_task()
    {
        $project = Project::factory()->hasTasks(1, ['body' => 'some task',])->create();
        $this->assertCount(2, $project->activity);
        tap($project->activity->first(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }


    public function test_complete_a_task()
    {
        $project = Project::factory()->create();
        $this->signIn($project->owner);
        $task = $project->addTask('some task');
        $this->patch($task->path(), ['body' => 'some task', 'completed' => true]);
        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->first()->description);
    }

    public function test_incomplete_a_task()
    {
        $project = Project::factory()->create();
        $this->signIn($project->owner);
        $task = $project->addTask('some task');
        $task->complete();

        $this->patch($task->path(), [
            'body' => 'some task',
            'completed' => false
        ]);
        $this->assertCount(4, $project->refresh()->activity);
        $this->assertEquals('uncompleted_task', $project->activity->first()->description);
    }

    public function test_update_and_complete_a_task()
    {
        $project = Project::factory()->create();
        $task = $project->addTask('some task');
        $this->signIn($project->owner);
        $this->patch($task->path(), ['body' => 'updated task', 'completed' => true]);
        $this->assertCount(4, $project->activity);
        $this->assertEquals('completed_task', $project->activity->first()->description);
    }

    public function test_deleting_a_task()
    {
        $project = Project::factory()->hasTasks()->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
    }


}
