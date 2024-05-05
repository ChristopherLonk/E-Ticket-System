<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Role;
use App\User;
use App\Project;
use App\Ticket;
use App\Sprint;

class DashboardTest extends TestCase
{


    /**
     * $user is a User Object
     * @var App\User
     */
    private $user;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setup (): void
    {
        Parent::setup();

        $role = Role::where('name', 'User')->first();
        $user = factory(\App\User::class)->make();
        $user->save();
        $user->attachRole($role);
        $this->user = $user;
    }

    /**
     * Test the index method from DashboardController with user and no user
     * @return void
     */
    public function testIndex()
    {
        $project = factory(\App\Project::class)->make();
        $project->save();

        $this->get('/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('/dashboard')
            ->assertSuccessful()
            ->assertViewIs('layouts.dashboard.index')
            ->assertSee('project')
            ->getOriginalContent()
            ->getData(Project::allActive());

        $project->delete();
    }

    /**
     * Test the Ticket by Sprint id method from DashboardController with user and no user
     * @return void
     */
    public function testTicketBySprintId(){
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        for ($i=0; $i < 10; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $project->id;
            $ticket->sprint_id = $sprint->id;
            $ticket->created_from = $this->user->id;
            $ticket->save();
        }

        $tickets = [
            'toDo' => Ticket::where('sprint_id', $sprint->id)->where('status', 'toDo')->get(),
            'barrier' => Ticket::where('sprint_id', $sprint->id)->where('status', 'barrier')->get(),
            'inProgress' => Ticket::where('sprint_id', $sprint->id)->where('status', 'inProgress')->get(),
            'codeReview' => Ticket::where('sprint_id', $sprint->id)->where('status', 'codeReview')->get(),
            'done' => Ticket::where('sprint_id', $sprint->id)->where('status', 'done')->get()
        ];


        $this->get('/dashboard/sprint/ticket/'.$sprint->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('/dashboard/sprint/ticket/'.$sprint->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.dashboard.project')
            ->assertSee('ToDo')
            ->assertSee('Barrier')
            ->assertSee('InProgress')
            ->assertSee('CodeReview')
            ->assertSee('Done')
            ->getOriginalContent()
            ->getData($tickets);

        Ticket::deleteAllTicketsByProjectId($project->id);
        Sprint::deleteAllSprintsByProjectId($project->id);
        $project->delete();

    }

    /**
     * Test the Edit Status by Ticket Id method from DashboardController with user and no user
     * @return void
     */
    public function testEditStatusByTicketId(){
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->sprint_id = $sprint->id;
        $ticket->created_from = $this->user->id;
        $ticket->save();

        $ticketTemp = $ticket;
        $ticketTemp->user_id = $this->user->id;
        $ticketTemp->status_id = 1;

        $this->get('dashboard/api/edit/ticket/'.$ticket->ext_id.'/status/1')
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('dashboard/api/edit/ticket/'.$ticket->ext_id.'/status/1')
            ->assertSuccessful();

        $this->assertEquals($ticketTemp, $ticket);

        Ticket::deleteAllTicketsByProjectId($project->id);
        Sprint::deleteAllSprintsByProjectId($project->id);
        $project->delete();

    }

    /**
     * Test the Details method from DashboardController with user and no user
     * @return void
     */
    public function testDetails() {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->sprint_id = $sprint->id;
        $ticket->created_from = $this->user->id;
        $ticket->save();


        $this->get('dashboard/api/details/'.$ticket->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('dashboard/api/details/'.$ticket->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.dashboard.details')
            ->assertSee($ticket->description)
            ->getOriginalContent()
            ->getData(Ticket::find($ticket->id));


        Ticket::deleteAllTicketsByProjectId($project->id);
        Sprint::deleteAllSprintsByProjectId($project->id);
        $project->delete();
    }

    /**
     * Test the Sprint method from DashboardController with user and no user
     * @return void
     */
    public function testSprint()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        for ($i = 0; $i < 5; $i++) {
            $sprint = factory(\App\Sprint::class)->make();
            $sprint->project_id = $project->id;
            $project->save();
        }
        $this->get('/dashboard/sprint/'.$project->id)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('/dashboard/sprint/'.$project->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.dashboard.sprint')
            ->assertSee('Sprint')
            ->getOriginalContent()
            ->getData(Project::find($project->id)->sprint());

        Sprint::deleteAllSprintsByProjectId($project->id);
        $project->delete();
    }

    /**
     * Test the Project method from DashboardController with user and no user
     * @return void
     */
    public function testProject(){
        $project = factory(\App\Project::class)->make();
        $project->save();
        for ($i=0; $i < 10; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $project->id;
            $ticket->created_from = $this->user->id;
            $ticket->save();
        }
        $tickets = [
	            "backlog" => Ticket::where('project_id', $project->id)->where('status', 'backlog')->take(10)->orderBy('priority', 'desc')->get(),
	            'toDo' => Ticket::where('project_id', $project->id)->where('status', 'toDo')->get(),
	            'barrier' => Ticket::where('project_id', $project->id)->where('status', 'barrier')->get(),
	            'inProgress' => Ticket::where('project_id', $project->id)->where('status', 'inProgress')->get(),
	            'codeReview' => Ticket::where('project_id', $project->id)->where('status', 'codeReview')->get(),
	            'done' => Ticket::where('project_id', $project->id)->where('status', 'done')->get()
	        ];
        $this->get("/dashboard/".$project->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get("/dashboard/".$project->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.dashboard.project')
            ->assertSee('ToDo')
            ->assertSee('Barrier')
            ->assertSee('InProgress')
            ->assertSee('CodeReview')
            ->assertSee('Done')
            ->getOriginalContent()
            ->getData($tickets);

        Ticket::deleteAllTicketsByProjectId($project->id);
        $project->delete();
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void{
        $this->user->delete();
    }
}
