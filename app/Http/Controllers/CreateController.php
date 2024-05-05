<?php

namespace App\Http\Controllers;

use App\Project;
use App\Sprint;
use App\Ticket;

class CreateController extends Controller
{
    /**
     * If the User auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Give all Projects Sprints and Tickets back to the View
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('layouts/create/index', ['projects' => Project::allActive(), 'sprints' => Sprint::allActive(), 'tickets' => Ticket::allActive()]);
    }
}
