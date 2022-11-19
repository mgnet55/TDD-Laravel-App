<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

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
        $this->get('/projects/'.Project::factory()->create()->id)
            ->assertRedirect('login');

    }

    public function test_a_user_can_see_thier_project()
    {

        $this->actingAs($user = User::factory()->hasProjects()->create());

        $project = $user->projects()->first();

        $this->get('/projects/'.$project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);

    }

    public function test_a_user_cannot_see_others_project()
    {

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get('/projects/'.$project->id)
            ->assertStatus(404);
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->create());
        $projectAttributes = Project::factory()->raw(['owner_id' => $user->id]);

        $this->post('/projects', $projectAttributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $projectAttributes);
        $this->get('/projects')->assertSee($projectAttributes['title']);
    }


    public function test_project_creation_requires_title()
    {
        $this->actingAs(User::factory()->create());
        $this->post('/projects', Project::factory()->raw(['title' => '']))
            ->assertSessionHasErrors('title');

    }

    public function test_project_creation_requires_description()
    {
        $this->actingAs(User::factory()->create());
        $this->post('/projects', Project::factory()->raw(['description' => '']))
            ->assertSessionHasErrors('description');

    }


}
