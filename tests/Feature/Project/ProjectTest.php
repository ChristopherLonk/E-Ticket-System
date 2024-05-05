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

class ProjectTest extends TestCase {

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
    public function setUp(): void
    {
        parent::setUp();
        $role = Role::where('name', 'Teamleader')->first();
        $this->user = factory(\App\User::class)->make();
        $this->user->save();
        $this->user->attachRole($role);

        $this->project = factory(\App\Project::class)->make();
        $this->project->save();
    }

    /**
     * Test the Create method from ProjectController with user and no user
     * @return void
     */
    public function testCreateGet() {
        $this->get('/project/create')
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('/project/create')
            ->assertSuccessful()
            ->assertViewIs('layouts.project.create')
            ->assertSee('method')
            ->assertSee('Project Name');
    }

    /**
     * Test the delete method from ProjectController with user and no user
     * @return void
     */
    public function testDeleteGet() {
        $this->get("/project/delete/" . $this->project->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/project/delete/".$this->project->ext_id)
            ->assertSuccessful();
    }

    /**
     * Test the delete method from ProjectController and delete all sprints  with user and no user
     * @return void
     */
    public function testDeleteSprintsGet() {
        for ($i=0; $i < 10; $i++) {
            $sprint = factory(\App\Sprint::class)->make();
            $sprint->project_id = $this->project->id;
            $sprint->save();
        }
        $this->get("/project/delete/".$this->project->ext_id)
            ->assertRedirect('/login');


        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/project/delete/".$this->project->ext_id)
            ->assertSuccessful();

        Sprint::deleteAllSprintsByProjectId($this->project->id);
    }

    /**
     * Test the delete method from ProjectController and delete all tickets  with user and no user
     * @return void
     */
    public function testDeleteTicketsGet() {
        for ($i=0; $i < 10; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $this->project->id;
            $ticket->created_from = $this->user->id;
            $ticket->save();
        }
        $this->get("/project/delete/" . $this->project->ext_id)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->followingRedirects()
            ->get("/project/delete/" . $this->project->ext_id)
            ->assertSuccessful();

        Ticket::deleteAllTicketsByProjectId( $this->project->id );
    }

    /**
     * Test the edit method from ProjectController with user and no user
     * @return void
     */
    public function testEditGet(){
        $this->get('/project/edit/2')
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get("/project/edit/".$this->project->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.project.edit')
            ->assertSee($this->project->name);
    }

    /**
     * Test the create method from ProjectController with user and no user
     * @return void
     */
    public function testCreatePost() {
        $this->json('POST', '/project/create', [
                'name' => 'phpUnitProject5',
                'method' => 'Kanban'
        ])->assertStatus(401);

        $this->actingAs($this->user)->followingRedirects()
            ->json('POST', '/project/create', [
                'name' => 'phpUnitProject6',
                'method' => 'kanban'
            ])->assertSuccessful();

        Project::where('name', 'phpUnitProject6')->first()->delete();
    }

    /**
     * Test the edit method from ProjectController with user and no user
     * @return void
     */
    public function testEditPost() {
        $this->json('POST', "/project/edit/".$this->project->ext_id, [
                'name' => 'phpUnitProject8',
                'method' => 'Kanban'
        ])->assertStatus(401);

        $this->actingAs($this->user)->followingRedirects()
            ->json('POST', "/project/edit/".$this->project->ext_id, [
                'name' => 'phpUnitProjecting',
                'method' => 'Scrum'
            ])->assertSuccessful();
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
