<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_projects()
    {
        $this->assertInstanceOf(Collection::class, User::factory()->create()->projects);
    }

    public function test_a_user_has_accessible_projects()
    {

        [$sally, $nick, $john] = User::factory(3)->create();
        [$sallyProject,] = Project::factory(2)->sequence(['owner_id' => $sally->id], ['owner_id' => $john->id])->create();

        $this->signIn($john);

        $sallyProject->invite($nick);
        $this->assertCount(1, $john->accessibleProjects());
        $sallyProject->invite($john);
        $this->assertCount(2, $john->accessibleProjects());


    }


}
