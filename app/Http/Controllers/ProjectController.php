<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tools;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectEditRequest;

class ProjectController extends Controller {

    /**
     * If the User auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Give back the View layouts/project/create
     * @return \Illuminate\View\View
     */
    public function createGet() {
        return view('layouts/project/create');
    }

    /**
     * Checked the requestObject and create a new Project if is not rigth with the RequestObject then give a massege back to the Browser
     * @param \App\Http\Controller\Requests\ProjectRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function createPost(ProjectRequest $request) {
        $randomByte = Tools::randomByte();

        while(!empty(Project::where('ext_id', $randomByte)->first())){
            $randomByte = Tools::randomByte();
        }

        $data = [
            'name' => $request->name,
            'method' => $request->method,
            'ext_id' => $randomByte
        ];

        Project::create($data);
        return redirect('create');
    }

    /**
     * Checked the requestObject and update a Project by the Id if is not rigth with the RequestObject then give a massege back to the Browser
     * @param \App\Http\Controller\Requests\ProjectEditRequest $request
     * @param string $extId
     * @return \Illuminate\Routing\Redirector
     */
    public function editPost(string $extId, ProjectEditRequest $request) {
        $project = Project::where('ext_id',$extId)->first();
        $project->fill($request->all());
        $project->save();
        return redirect('create');
    }

    /**
     * Give the project by the id to the View and fill the Formular with the Project Data
     * @param  string $extId
     * @return \Illuminate\View\View
     */
    public function editGet(string $extId) {
        return view('layouts/project/edit', ['project' => Project::where('ext_id',$extId)->first()]);
    }

    /**
     * Is set a Flack in the database is_delete by Project, Sprint and Ticket
     * @param string $extId
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(string $extId) {
        $project = Project::where('ext_id',$extId)->first();
        foreach ($project->sprint() as $key => $sprint) {
            $sprint->is_delete = 1;
            $sprint->save();
        }
        foreach ($project->ticket() as $key => $ticket) {
            $ticket->is_delete = 1;
            $ticket->save();
        }
        $project->is_delete = 1;

        $project->save();
        return redirect('create');
    }

}
