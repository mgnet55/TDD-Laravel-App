<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();
        $this->signIn($project->owner);

        $userToInvite = User::factory()->create();

        $this->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));

    }

    public function test_non_project_owner_cannot_invite_user()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->post($project->path() . '/invitations', [
            'email' => $userToInvite = User::factory()->create()->email
        ])->assertStatus(403);

        $this->assertFalse($project->members->contains($userToInvite));
    }

    public function test_the_email_must_be_associated_with_a_valid_account()
    {

        $project = Project::factory()->create();
        $this->signIn($project->owner);

        $this->post($project->path() . '/invitations', ['email' => 'notauser@example.com'])
            ->assertSessionHasErrors('email', errorBag: 'invitations');

    }

    public function test_invited_user_may_update_project()
    {
        $project = Project::factory()->create();
        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);
        $this->followingRedirects()->post($project->path() . '/tasks', ['body' => 'new task'])
            ->assertSee('new task');

        $this->assertDatabaseHas('tasks', ['body' => 'new task']);

    }
}
