<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\Sprint;
use App\Ticket;
use App\User;

class SprintTest extends TestCase {

    /**
     * If check the SprintObject = Sprint::AllActive()
     * @return void
     */
    public function testAllActive() {
        $sprint = Sprint::allActive();
        $sprintsTemp = Sprint::all();
        $count = 0;
        foreach ($sprintsTemp as $key => $sprintTemp) {
            if (is_null($sprintTemp->isDelete)) {
                $count++;
            }
        }
        $this->assertEquals(count($sprint), $count);
    }

    /**
     * If check the ProjectObject = Project::find($project->id)
     * @return void
     */
    public function testProject() {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        $projectTemp = $sprint->project();
        $project = Project::find($project->id);

        $this->assertEquals($projectTemp, $project);
        $sprint->delete();
        $project->delete();
    }

    /**
     * If check the TicketObject = Ticket::where('sprint_id', $ticket->sprint_id)->get()
     * @return void
     */
    public function testTicket() {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $sprint = factory(\App\Sprint::class)->make();
        $sprint->project_id = $project->id;
        $sprint->save();

        $user = factory(\App\User::class)->make();
        $user->save();

        for ($i = 0; $i < 5; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $project->id;
            $ticket->sprint_id = $sprint->id;
            $ticket->created_from = $user->id;
            $ticket->save();
        }

        $ticketTemp = $sprint->ticket();
        $tickets = Ticket::where('sprint_id', $ticket->sprint_id)->get();

        $this->assertEquals($ticketTemp, $tickets);

        Ticket::deleteAllTicketsByProjectId($project->id);
        $user->delete();
        $sprint->delete();
        $project->delete();
    }
}
