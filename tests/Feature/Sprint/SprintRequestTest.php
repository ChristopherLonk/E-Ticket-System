<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Project;
use App\Sprint;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SprintRequestTest extends TestCase
{
    /**
     * $user is the UserObject
     * @var App\User
     */
    private $user;

    /**
     * $project is the ProjectObject
     * @var App\Project
     */
    private $project;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setup(): void
    {
        parent::setUp();
        $role = Role::where('name', 'Teamleader')->first();
        $this->user = factory(\App\User::class)->make();
        $this->user->save();
        $this->user->attachRole($role);

        $this->project = factory(\App\Project::class)->make();
        $this->project->method = 'Scrum';
        $this->project->save();
    }

    /**
     * Test the RequestObject the field name
     * @return void
     */
    public function testRequestName()
    {
        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'from' => '2018-04-28 00:00:00',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
                'from' => '2018-04-28 00:00:00',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'from' => '2018-04-28 00:00:00',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(200);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'from' => '2018-04-28 00:00:00',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);
        Sprint::where('name', 'SprintTest')->first()->delete();
    }

    /**
     * Test the RequestObject The field From
     * @return void
     */
    public function testRequestFrom()
    {
        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'from' => 'Test',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'from' => '2018-04-28 00:',
                'to'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field to
     * @return void
     */
    public function testRequestTo()
    {
        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'from'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'to' => 'Test',
                'from'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'SprintTest',
                'to' => '2018-04-28 00:',
                'from'   => '2018-04-28 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(422);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->project->delete();
        $this->user->delete();
    }
}
