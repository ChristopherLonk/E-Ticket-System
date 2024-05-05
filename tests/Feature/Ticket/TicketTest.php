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

class TicketTest extends TestCase
{
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
     * $ticket TicketObject
     * @var App\Ticket
     */
    private $ticket;

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

        $this->project = factory(\App\Project::class)->make();
        $this->project->method = 'Scrum';
        $this->project->save();

        $this->sprint = factory(\App\Sprint::class)->make();
        $this->sprint->project_id = $this->project->id;
        $this->sprint->save();

        $this->ticket = factory(\App\Ticket::class)->make();
        $this->ticket->project_id = $this->project->id;
        $this->ticket->created_from = $this->user->id;
        $this->ticket->save();
    }

    /**
     * Test the Create method from TicketController with user and no user
     * @return void
     */
    public function testCreateGet()
    {
        $this->get('/ticket/create')
            ->assertStatus(302);
        $this->actingAs($this->user)
            ->get('/ticket/create')
            ->assertSuccessful()
            ->assertViewIs('layouts.ticket.create')
            ->assertSee('Description');
    }

    /**
     * Test the Delete method from TicketController with user and no user
     * @return void
     */
    public function testDeleteGet()
    {
        $this->get("/ticket/delete/".$this->ticket->ext_id)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/ticket/delete/".$this->ticket->ext_id)
            ->assertStatus(200)
            ->assertViewIs('layouts.create.index');
    }

    /**
     * Test the Edit method from TicketController with user and no user
     * @return void
     */
    public function testEditGet()
    {
        $this->followingRedirects()
            ->get("/ticket/edit/".$this->ticket->ext_id)
            ->assertStatus(200)
            ->assertViewIs('auth.login');

        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/ticket/edit/".$this->ticket->ext_id)
            ->assertStatus(200)
            ->assertViewIs('layouts.ticket.edit')
            ->assertSee($this->ticket->name);
    }

    /**
     * Test the Create method from TicketController with user and no user
     * @return void
     */
    public function testCreatePost()
    {
        $this->json('POST', '/ticket/create', [
                'name' => 'phpUnitTicket',
                'description' => 'phpUnitDescription',
                'project' => $this->project->name
        ])->assertStatus(401);

        $this->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpUnitTicket',
                'description' => 'phpUnitDescription',
                'project' => $this->project->name
            ])->assertRedirect('/create');

        $this->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpUnitTicket1',
                'description' => 'phpUnitDescription',
                'project' => 'firstProjectsPhpUnit'
            ])->assertRedirect('/ticket/create');

        Ticket::where('name', 'phpUnitTicket')->first()->delete();
    }

    /**
     * Test the Edit method from TicketController with user and no user
     * @return void
     */
    public function testEditPost()
    {
        $this->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
            'name' => 'phpUnitTicket',
            'description' => 'phpUnitDescription',
            'project' => $this->project->name
        ])->assertStatus(401);

        $this->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpUnitTicket1',
                'description' => 'phpUnitDescription1',
                'project' => $this->project->name,
                'status' => 'backlog',
                'storyPoints' => 1,
                'priority' => 'Low'
            ])->assertRedirect('/create');

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpUnitTicket1',
                'description' => 'phpUnitDescription1',
                'project' => 'TestProjectfhskfskjehfkjscksjhdfs',
                'status' => 'backlog',
                'storyPoints' => 0,
                'priority' => 'Low'
            ])->assertStatus(200)
            ->assertViewIs('layouts.ticket.edit');
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->ticket->delete();
        $this->sprint->delete();
        $this->project->delete();
        $this->user->delete();
    }
}
