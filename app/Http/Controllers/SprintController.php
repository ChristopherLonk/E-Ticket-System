<?php

namespace App\Http\Controllers;

use App\Sprint;
use App\Project;
use App\Tools;
use App\Http\Requests\SprintRequest;
use App\Http\Requests\SprintEditRequest;

class SprintController extends Controller
{
    /**
     * If the User auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Give all Project where Scrum and activ to the View layouts/sprint/create
     * @return \Illuminate\View\View
     */
    public function createGet()
    {
        return view('layouts/sprint/create', ['projects' => Project::allScrumAndActive()]);
    }

    /**
     * Give all Project where Scrum and activ is to the View layouts/sprint/create
     * @param \App\Http\Controller\Requests\SprintRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function createPost(SprintRequest $request)
    {
        $project = Project::where('name', $request->input('project'))->where('method', 'Scrum')->where('is_delete', null)->first();
        if (!empty($project)) {
            $randomByte = Tools::randomByte();

            while (!empty(Sprint::where('ext_id', $randomByte)->first())) {
                $randomByte = Tools::randomByte();
            }

            $data = [
                'name' => $request->input('name'),
                'to' => $request->input('to'),
                'from' => $request->input('from'),
                'project_id' => $project->id,
                'ext_id' => $randomByte
            ];
            Sprint::create($data);
            return redirect('create');
        } else {
            return redirect('/sprint/create');
        }
    }

    /**
     * Give all Project where Scrum and activ is and the Sprint to the View and fill the Formular with Sprint Data
     * @param string $extId
     * @return \Illuminate\View\View
     */
    public function editGet(string $extId)
    {
        return view('layouts/sprint/edit', ['sprint' => Sprint::where('ext_id', $extId)->first(), 'projects' => Project::allScrumAndActive()]);
    }

    /**
     * Update the Sprint and check the rules from SprintRequest
     * @param  string $extId
     * @param  SprintEditRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function editPost(string $extId, SprintEditRequest $request)
    {
        $project = Project::where('name', $request->input('project'))->where('method', 'Scrum')->where('is_delete', null)->first();
        if (!empty($project)) {
            $data = [
                'name' => $request->input('name'),
                'to' => $request->input('to'),
                'from' => $request->input('from'),
                'project_id' => $project->id
            ];

            $sprint = Sprint::where('ext_id', $extId)->first();
            $sprint->update($data);
            return redirect('create');
        } else {
            return redirect("/sprint/edit/$extId");
        }
    }

    /**
     * Is set the Flack is_delete from a Sprint and all Ticket from the Sprint
     * @param string $extId
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(string $extId)
    {
        $sprint = Sprint::where('ext_id', $extId)->first();

        foreach ($sprint->ticket() as $key => $ticket) {
            $ticket->is_delete = 1;
            $ticket->save();
        }
        $sprint->is_delete = 1;
        $sprint->save();

        return redirect('create');
    }
}
