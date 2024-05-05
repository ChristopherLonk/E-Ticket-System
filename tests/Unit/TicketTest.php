<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Ticket;
use App\Sprint;
use App\Project;
use App\User;

class TicketTest extends TestCase
{
    /**
     * If check all active Tickets
     * @return void
     */
    public function testAllActive()
    {
        $tickets = Ticket::allActive();
        $ticketsTemp = Ticket::all();
        $count = 0;
        foreach ($ticketsTemp as $key => $ticketTemp) {
            if (is_null($ticketTemp->isDelete)) {
                $count++;
            }
        }
        $this->assertEquals(count($tickets), $count);
    }

    /**
     * if Check the Sprint method in a Ticket Model
     * @return void
     */
    public function testSprint()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        $sprint = Sprint::find($sprint->id)->first();

        $user = factory(\App\User::class)->make();
        $user->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->sprint_id = $sprint->id;
        $ticket->created_from = $user->id;
        $ticket->save();

        $sprintTemp = $ticket->sprint();
        $this->assertEquals($sprintTemp, $sprint);

        $ticket->delete();
        $user->delete();
        $sprint->delete();
        $project->delete();
    }

    /**
     * if check the Project method in the Ticket Model
     * @return void
     */
    public function testProject()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Kanban';
        $project->save();

        $project = Project::where('id', $project->id)->first();

        $user = factory(\App\User::class)->make();
        $user->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->created_from = $user->id;
        $ticket->save();

        $projectTemp = $ticket->project();

        $this->assertEquals($projectTemp, $project);

        $ticket->delete();
        $user->delete();
        $project->delete();
    }

    /**
     * if check the User method in the Ticket Model
     * @return void
     */
    public function testUser()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Kanban';
        $project->save();

        $user = factory(\App\User::class)->make();
        $user->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->created_from = $user->id;
        $ticket->save();

        $userTemp = $ticket->user();
        $userArray = User::find($ticket->user_id);

        $this->assertEquals($userTemp, $userArray);

        $ticket->delete();
        $user->delete();
        $project->delete();
    }

    /**
     * if check the Create From method in the Ticket Model
     * @return void
     */
    public function testCreateFrom()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Kanban';
        $project->save();

        $user = factory(\App\User::class)->make();
        $user->save();

        $ticket = factory(\App\Ticket::class)->make();
        $ticket->project_id = $project->id;
        $ticket->created_from = $user->id;
        $ticket->save();

        $userTemp = $ticket->createFrom();
        $user = User::find($ticket->created_from);

        $this->assertEquals($userTemp, $user);

        $ticket->delete();
        $user->delete();
        $project->delete();
    }
}
