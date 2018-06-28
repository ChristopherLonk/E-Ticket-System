<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Ticket;
use App\Project;
use App\Sprint;

class DashboardController extends Controller {

    /**
     * If the User auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Give all Projects to the View
     * @return \Illuminate\View\View
     */
    public function dashboard() {

        return view('layouts/dashboard/index', ['projects' => Project::allActive()]);
    }

    /**
     * Give the Ticket by id to the View
     * @param string $extId
     * @return \Illuminate\View\View
     */
    public function details(string $extId ) {
        return view('layouts/dashboard/details', ['ticket' => Ticket::where('ext_id',$extId)->first()]);
    }

    /**
     * Give the Sprint by Project id to the View
     * @param string $extId
     * @return \Illuminate\View\View
     */
    public function sprint(string $extId) {
        return view('layouts/dashboard/sprint', ['sprints' => Project::where('ext_id', $extId)->first()->sprint()]);
    }

    /**
     * Give all Tickets by Sprint id to the View with the order by status
     * @param string $extId
     * @return \Illuminate\View\View
     */
    public function ticketBySprintId(string $extId) {
        $sprint = Sprint::where('ext_id',$extId)->first();
        $tickets = [
            'toDo' => Ticket::where('sprint_id', $sprint->id)->where('status', 'toDo')->get(),
            'barrier' => Ticket::where('sprint_id', $sprint->id)->where('status', 'barrier')->get(),
            'inProgress' => Ticket::where('sprint_id', $sprint->id)->where('status', 'inProgress')->get(),
            'codeReview' => Ticket::where('sprint_id', $sprint->id)->where('status', 'codeReview')->get(),
            'done' => Ticket::where('sprint_id', $sprint->id)->where('status', 'done')->get()
        ];

        return view('layouts/dashboard/project', ['tickets' => $tickets]);
    }

    /**
     * Edit Status and the User by the Ticket id
     * @param string $extId
     * @param int $statusId Status Id is 1 = backlog, 2 = toDo , 3 = barrier, 4 = inProgress, 5 = codeReview, 6 = done
     * @return int
     */
    public function editStatusByTicketId(string $extId, int $statusId) {
        $ticket = Ticket::where('ext_id', $extId)->first();
        $ticket->user_id = Auth::id();
        $ticket->status = $statusId;
        $ticket->save();
        return $ticket->sprint()->ext_id;
    }

    /**
      * Give all Tickets by Sprint id to the View with the order by status
      * @param string $extId
      * @return \Illuminate\View\View
      */
    public function project(string $extId) {
        $project = Project::where('ext_id', $extId)->first();
        $tickets = [
            "backlog" => Ticket::where('project_id', $project->id)->where('status', 'backlog')->take(10)->orderBy('priority', 'desc')->get(),
            'toDo' => Ticket::where('project_id', $project->id)->where('status', 'toDo')->get(),
            'barrier' => Ticket::where('project_id', $project->id)->where('status', 'barrier')->get(),
            'inProgress' => Ticket::where('project_id', $project->id)->where('status', 'inProgress')->get(),
            'codeReview' => Ticket::where('project_id', $project->id)->where('status', 'codeReview')->get(),
            'done' => Ticket::where('project_id', $project->id)->where('status', 'done')->get()
        ];
        return view('layouts/dashboard/project', ['tickets' => $tickets]);
    }

}
