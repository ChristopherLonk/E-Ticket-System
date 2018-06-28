<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Project;
use App\Sprint;
use App\Tools;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketEditRequest;

class TicketController extends Controller {

    /**
     * Check if User Auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
      * Give all Project activ to the View layouts/ticket/create
     * @return \Illuminate\View\View
     */
    public function createGet() {
        return view('layouts/ticket/create', ['projects' => Project::allActive()]);
    }

    /**
     * Create a new Ticket and check if validate of the Object TicketRequest
     * @param  TicketRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function createPost(TicketRequest $request) {
        $project = Project::where('name', $request->input('project'))->where('is_delete', NULL)->first();
        if (!empty($project)) {

            $randomByte = Tools::randomByte();

            while(!empty(Ticket::where('ext_id', $randomByte)->first())){
                $randomByte = Tools::randomByte();
            }

            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'project_id' => $project->id,
                'created_from' => Auth::id(),
                'status' => 1,
                'storyPoints' => 1,
                'priority' => 1,
                'ext_id' => $randomByte
            ];
            Ticket::create($data);
            return redirect('create');
        } else {
            return redirect('/ticket/create');
        }
    }

    /**
     * Give the Ticket by id to the View and fill the Formular with Ticket Date
     * @param  string $extId
     * @return \Illuminate\View\View
     */
    public function editGet(string $extId) {
        return view('layouts/ticket/edit', [
            'storyPoints' => Ticket::readEnum('storyPoints'),
            'stati' => Ticket::readEnum('status'),
            'priorities' => Ticket::readEnum('priority'),
            'ticket' => Ticket::where('ext_id',$extId)->first(),
            'projects' => Project::allActive()]);
    }


    /**
     * Edit the Ticket by Id and validate the Formular
     * @param TicketEditRequest $request
     * @param string $extId
     * @return \Illuminate\Routing\Redirector
     */
    public function editPost(TicketEditRequest $request, string $extId) {
        $project = Project::where('name', $request->input('project'))->where('is_delete', NULL)->first();
        $sprint = Sprint::where('name', $request->input('sprint'))->where('is_delete', NULL)->first();
        if(!empty($sprint)){
            $sprint_id = $sprint->id;
        }else{
            $sprint_id = NULL;
        }
        if (!empty($project)) {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'project_id' => $project->id,
                'created_from' => Auth::id(),
                'status' => $request->input('status'),
                'storyPoints' => $request->input('storyPoints'),
                'priority' => $request->input('priority'),
                'sprint_id' => $sprint_id
            ];
            $ticket = Ticket::where('ext_id', $extId)->first();
            $ticket->update($data);
            return redirect('create');
        } else {
            return redirect("ticket/edit/$extId");
        }
    }

    /**
     * delete is set a flack in the Ticket is_deleted by Ticket Id
     * @param  string $extId
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(string $extId) {
        $ticket = Ticket::where('ext_id',$extId)->first();
        $ticket->is_delete = 1;
        $ticket->save();

        return redirect('create');
    }

}
