<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Project;
use App\Sprint;
use App\Ticket;

use App\Role;
use App\User;

class SprintTest extends TestCase {

    /**
     * $user is a User Object
     * @var App\User
     */
    private $user;

    /**
     * $project is a Project Object
     * @var App\Project
     */
    private $project;

    /**
     * $sprint is a Sprint Object
     * @var App\Sprint
     */
    private $sprint;

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

        $this->sprint = factory(\App\Sprint::class)->make();
        $this->sprint->project_id = $this->project->id;
        $this->sprint->save();
    }

    /**
     * Test the Create method from SprintController with user and no user
     * @return void
     */
    public function testCreateGet() {
        $this->get('/sprint/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->get('/sprint/create')
            ->assertSuccessful()
            ->assertViewIs('layouts.sprint.create')
            ->assertSee('Sprint Name')
            ->assertSee('From')
            ->assertSee('To')
            ->assertSee('Project');
    }


    /**
     * Test the delete method from SprintController with user and no user
     * @return void
     */
    public function testDeleteGet() {
        $this->get("/sprint/delete/".$this->sprint->ext_id)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/sprint/delete/".$this->sprint->ext_id)
            ->assertStatus(200);
    }

    /**
     * Test the delete method from SprintController and delete all Tickets with user and no user
     * @return void
     */
    public function testDeleteTicketsGet() {
        for ($i=0; $i < 10; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $this->project->id;
            $ticket->sprint_id = $this->sprint->id;
            $ticket->created_from = $this->user->id;
            $ticket->save();
        }

        $this->get("/sprint/delete/".$this->sprint->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');;

        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/sprint/delete/".$this->sprint->ext_id)
            ->assertStatus(200);

        Ticket::deleteAllTicketsBySprintId($this->sprint->id);
    }

    /**
     * Test the edit method from SprintController with user and no user
     * @return void
     */
    public function testEditGet(){
        $this->get('/sprint/edit/'.$this->sprint->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->get("/sprint/edit/".$this->sprint->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.sprint.edit')
            ->assertSee($this->sprint->name);
    }

    /**
     * Test the create method from SprintController with user and no user
     * @return void
     */
    public function testCreatePost() {
        $this->json('POST', '/sprint/create', [
                'name' => 'phpUnitSprint',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => $this->project->name
        ])->assertStatus(401);

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'phpUnitSprint',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => $this->project->name
            ])->assertRedirect('/create');

        $this->actingAs($this->user)
            ->json('POST', '/sprint/create', [
                'name' => 'phpUnitSprint1',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => 'phpunitTest3'
            ])->assertRedirect('/sprint/create');

        Sprint::where('name', 'phpUnitSprint')->first()->delete();
    }

    /**
     * Test the edit method from SprintController with user and no user
     * @return void
     */
    public function testEditPost() {
        $this->json('POST', "/sprint/edit/".$this->sprint->ext_id, [
                'name' => 'phpUnitSprint',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(401);

        $this->actingAs($this->user)
            ->followingRedirects()
            ->json('POST', "/sprint/edit/".$this->sprint->ext_id, [
                'name' => 'phpUnitSprint1',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => $this->project->name
            ])->assertStatus(200)
            ->assertViewIs('layouts.create.index');

        $this->actingAs($this->user)->followingRedirects()
            ->json('POST', "/sprint/edit/".$this->sprint->ext_id, [
                'name' => 'phpUnitSprint1',
                'from' => '2018-05-05 00:00:00',
                'to' => '2018-05-05 00:00:00',
                'project' => 'phpunitTest3Project'
            ])->assertStatus(200)
            ->assertViewIs('layouts.sprint.edit');
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->sprint->delete();
        $this->project->delete();
        $this->user->delete();
    }
}
