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

class ProjectTest extends TestCase
{
    /**
     * Count all tickets over the Model and over the database
     * @return void
     */
    public function testAllActive()
    {
        $projects = Project::allActive();
        $projectsTemp = Project::all();
        $count = 0;
        foreach ($projectsTemp as $key => $projectTemp) {
            if (is_null($projectTemp->isDelete)) {
                $count++;
            }
        }
        $this->assertEquals(count($projects), $count);
    }

    /**
     * Count all Scrum and Aktive over the Model and over the database
     * @return void
     */
    public function testScrumAndActive()
    {
        $projects = Project::allScrumAndActive();
        $projectsTemp = Project::all();
        $count = 0;
        foreach ($projectsTemp as $projectTemp) {
            if (is_null($projectTemp->isDelete) && $projectTemp->method == 'Scrum') {
                $count++;
            }
        }
        $this->assertEquals(count($projects), $count);
    }

    /**
     * Is check the SprintObject = $project->sprint()
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

        $sprintTemp = $project->sprint();
        $sprints = Sprint::where('project_id', $sprint->project_id)->get();
        $this->assertEquals($sprintTemp, $sprints);

        Sprint::deleteAllSprintsByProjectId($project->id);
        $project->delete();
    }

    /**
     * Is check the TicketObject = $project->ticket()
     * @return void
     */
    public function testTicket()
    {
        $project = factory(\App\Project::class)->make();
        $project->method = 'Scrum';
        $project->save();

        $user = factory(\App\User::class)->make();
        $user->save();
        for ($i = 0; $i < 5; $i++) {
            $ticket = factory(\App\Ticket::class)->make();
            $ticket->project_id = $project->id;
            $ticket->created_from = $user->id;
            $ticket->save();
        }

        $ticketTemp = $project->ticket();
        $tickets = Ticket::where('project_id', $ticket->project_id)->get();
        $this->assertEquals($ticketTemp, $tickets);
        Ticket::deleteAllTicketsByProjectId($project->id);
        $project->delete();
        $user->delete();
    }
}
