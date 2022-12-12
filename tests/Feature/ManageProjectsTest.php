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
    public function test_a_guest_cannot_create_project(): void
    {

        $this->post('/projects', Project::factory()->raw())
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_projects(): void
    {

        $this->get('/projects/')
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_a_single_project(): void
    {
        $this->get('/projects/' . Project::factory()->create()->id)
            ->assertRedirect('login');

    }

    public function test_a_guest_cannot_view_project_creation_form(): void
    {
        $this->get('/projects/create')
            ->assertRedirect('login');

    }


    // Authenticated User features
    public function test_project_creation_requires_title(): void
    {
        $this->signIn();
        $this->post('/projects', Project::factory()->raw(['title' => '']))
            ->assertSessionHasErrors('title');

    }

    public function test_project_creation_requires_description(): void
    {
        $this->signIn();
        $this->post('/projects', Project::factory()->raw(['description' => '']))
            ->assertSessionHasErrors('description');

    }

    public function test_a_user_can_create_a_project(): void
    {

        $this->signIn();

        $project = Project::factory()->raw(['owner_id' => auth()->id()]);

        $this->post('/projects', $project)
            ->assertRedirect('/projects/1');
        $this->assertDatabaseHas(Project::class, $project);
        $this->get('/projects')->assertSee($project['title']);
    }

    public function test_a_user_can_see_their_project(): void
    {

        $project = Project::factory()->create(['owner_id' => $this->signIn()->id]);

        $this->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee(\Str::limit($project->description))
            ->assertSee($project->notes);

    }

    public function test_a_user_can_see_all_invited_projects(): void
    {
        $project = Project::factory()->create();

        $user = $this->signIn();

        $project->invite($user);

        $this->get('/projects/')
            ->assertSee($project->title);

        $this->get('/projects/' . $project->id . '/edit')->assertOk();
    }

    public function test_project_owner_can_edit_their_project(): void
    {
        $project = Project::factory()->create(['owner_id' => $this->signIn()->id]);

        $this->get('/projects/' . $project->id . '/edit')->assertOk();

    }

    public function test_project_owner_can_update_their_project(): void
    {
        $project = Project::factory()->create(['owner_id' => $this->signIn()->id]);

        $this->patch($project->path(), $attributes = ['title' => 'title', 'description' => 'description', 'notes' => 'notes'])
            ->assertRedirect('/projects/' . $project->id);

        $this->assertDatabaseHas(Project::class, $attributes);

    }

    public function test_project_owner_can_delete_their_project(): void
    {
        $project = Project::factory()->create(['owner_id' => $this->signIn()->id]);

        $this->delete($project->path())
            ->assertRedirect('/projects/');

        $this->assertDatabaseMissing(Project::class, ['id' => $project->id]);

    }

    public function test_project_owner_can_update_their_project_notes_alone(): void
    {

        $project = Project::factory()->create(['owner_id' => $this->signIn()->id]);

        $this->patch('/projects/' . $project->id, ['notes' => 'notes'])
            ->assertRedirect('/projects/' . $project->id);

        $this->assertDatabaseHas(Project::class, ['notes' => 'notes']);
        $this->get('/projects/' . $project->id)
            ->assertSee('notes');

        $this->get('/projects/' . $project->id . '/edit')->assertOk();

    }

    // Project Owner features
    public function test_authenticated_user_cannot_see_others_project(): void
    {

        $this->signIn();

        $project = Project::factory()->create();

        $this->get('/projects/' . $project->id)
            ->assertStatus(403);
    }

    public function test_authenticated_user_cannot_update_project(): void
    {


        $project = Project::factory()->create();

        $this->patch('/projects/' . $project->id, ['notes' => 'updated'])->assertStatus(302)->assertRedirect('/login');
        $this->assertDatabaseMissing(Project::class, ['notes' => 'updated', 'id' => $project->id]);

        $this->signIn();
        $this->patch('/projects/' . $project->id, ['title' => 'title', 'description' => 'description'])->assertStatus(403);

        $this->assertDatabaseMissing(Project::class, ['notes' => 'updated', 'id' => $project->id]);

    }

    public function test_authenticated_user_cannot_delete_project(): void
    {
        $project = Project::factory()->create();

        $this->delete($project->path())->assertStatus(302)->assertRedirect('/login');
        $this->assertDatabaseHas(Project::class, ['id' => $project->id]);

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
        $this->assertDatabaseHas(Project::class, ['id' => $project->id]);


    }


}
