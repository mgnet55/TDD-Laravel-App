<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProjectTest extends TestCase
{
    use refreshDatabase;

    public function test_project_belongs_to_user()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class,$project->owner);

    }
}
