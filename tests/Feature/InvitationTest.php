<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;


    public function test_a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();
        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);
        $this->post($project->path() . '/tasks', ['body' => 'new task'])
            ->assertRedirect($project->path());

        $this->get($project->path())->assertSee('new task');

        $this->assertDatabaseHas('tasks', ['body' => 'new task']);

    }
}
