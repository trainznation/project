<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAccessProjectPage()
    {
        $user = User::factory()->create();
        //$this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get('/project');
        $response->assertSuccessful();
    }

    public function testAccessCreateProjectNormalize()
    {
        $user = User::factory()->create();
        //$this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get('/project/create');
        $response->assertSuccessful();
    }

    public function testCreateSuccessfullProject()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();

        $this->assertEquals(1, $project->count());
    }

}
