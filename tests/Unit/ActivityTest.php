<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_has_a_user()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf(User::class, $project->activity->first()->user);
        $this->assertEquals($project->owner_id, $project->activity->first()->user_id);
    }
}
