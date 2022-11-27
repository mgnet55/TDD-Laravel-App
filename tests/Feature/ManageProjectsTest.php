<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    // Guest Tests
    public function test_a_guest_cannot_create_project()
    {

        $this->post('/projects', Project::factory()->raw())
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_project()
    {

        $this->get('/projects/')
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_a_single_project()
    {
        $this->get('/projects/' . Project::factory()->create()->id)
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_project_creation_form()
    {
        $this->get('/projects/create')
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_update_project()
    {

        $project = Project::factory()->create();

        $this->patch('/projects/' . $project->id, ['notes' => 'updated'])->assertRedirect('/login');

        $this->assertDatabaseMissing(Project::class, ['notes' => 'updated', 'id' => $project->id]);

    }

    // Authenticated User features
    public function test_project_creation_requires_title()
    {
        $this->signIn();
        $this->post('/projects', Project::factory()->raw(['title' => '']))
            ->assertSessionHasErrors('title');

    }

    public function test_project_creation_requires_description()
    {
        $this->signIn();
        $this->post('/projects', Project::factory()->raw(['description' => '']))
            ->assertSessionHasErrors('description');

    }

    public function test_a_user_can_create_a_project()
    {

        $this->signIn();

        $project = Project::factory()->raw(['owner_id' => auth()->id()]);

        $this->post('/projects', $project)
            ->assertRedirect('/projects/1');
        $this->assertDatabaseHas(Project::class, $project);
        $this->get('/projects')->assertSee($project['title']);
    }


    public function test_a_user_can_see_thier_project()
    {

        $this->actingAs($user = User::factory()->hasProjects()->create());

        $project = $user->projects()->first();

        $this->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee(\Str::limit($project->description, 100))
            ->assertSee($project->notes);

    }

    public function test_project_owner_can_update_thier_project()
    {

        $this->actingAs($user = User::factory()->hasProjects()->create());

        $project = $user->projects()->first();

        $this->patch('/projects/' . $project->id, ['notes' => 'updated'])->assertRedirect('/projects/' . $project->id);

        $this->assertDatabaseHas(Project::class, ['notes' => 'updated', 'id' => $project->id]);
        $this->get('/projects/' . $project->id)->assertSee('updated');

    }

    // Project Owner features
    public function test_authenticated_user_cannot_see_others_project()
    {

        $this->signIn();

        $project = Project::factory()->create();

        $this->get('/projects/' . $project->id)
            ->assertStatus(403);
    }

    public function test_authenticated_user_cannot_update_others_project()
    {

        $this->actingAs($user = User::factory()->create());

        $anotherUser = User::factory()->hasProjects()->create();
        $project = $anotherUser->projects()->first();

        $this->patch('/projects/' . $project->id, ['notes' => 'updated'])->assertStatus(403);

        $this->assertDatabaseMissing(Project::class, ['notes' => 'updated', 'id' => $project->id]);

    }


}
