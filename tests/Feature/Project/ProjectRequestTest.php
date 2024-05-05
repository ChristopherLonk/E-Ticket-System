<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProjectRequestTest extends TestCase
{
    /**
     * user
     * @var App\User
     */
    private $user;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setUp(): void
    {
        parent::setUp();
        $role = Role::where('name', 'Teamleader')->first();
        $this->user = factory(\App\User::class)->make();
        $this->user->save();
        $this->user->attachRole($role);
    }

    /**
     * Test the Request Object with the name
     * @return void
     */
    public function testRequestName()
    {
        $this->actingAs($this->user)
            ->json('POST', '/project/create', [
                'method' => 'Scrum'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/project/create', [
                'name' => 'ph',
                'method' => 'Scrum'
            ])->assertStatus(422);


        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/project/create', [
                'name' => 'phpUnitProject',
                'method' => 'Scrum'
            ])->assertStatus(200);

        $this->actingAs($this->user)
            ->json('POST', '/project/create', [
                'name' => 'phpUnitProject',
                'method' => 'Scrum'
            ])->assertStatus(422);
        $project = Project::where('name', 'phpUnitProject')->first();
        $project->delete();
    }

    /**
     * Test the Request Object with the method
     * @return void
     */
    public function testRequestMethod()
    {
        $this->actingAs($this->user)
            ->json('POST', '/project/create', [
                'name' => 'phpunit'
            ])->assertStatus(422);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->user->delete();
    }
}
