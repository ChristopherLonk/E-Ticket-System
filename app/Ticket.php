<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'description', 'project_id', 'created_from', 'status', 'storyPoints', 'priority','ext_id', 'sprint_id'];

    /**
     * Delete all Ticket by the Project id
     * @param  int $id
     * @return void
     */
    static function deleteAllTicketsByProjectId(int $id)
    {
        $tickets = Ticket::where('project_id', $id)->get();
        foreach ($tickets as $key => $ticket) {
            $ticket->delete();
        }
    }

    /**
     * Delete all Ticket by the Sprint id
     * @param  int $id
     * @return void
     */
    static function deleteAllTicketsBySprintId(int $id)
    {
        $tickets = Ticket::where('sprint_id', $id)->get();
        foreach ($tickets as $key => $ticket) {
            $ticket->delete();
        }
    }

    /**
     * all active is search in Sprint table where is_delete = NULL
     * @return array
     */
    static function allActive()
    {
        return parent::where('is_delete', null)->get();
    }

    /**
     * Sprint give one of Projects back from the Sprint
     * @return App\Sprint
     */
    public function sprint()
    {
        return $this->hasOne('App\Sprint', 'id', 'sprint_id')->first();
    }

    /**
     * Project give one of Projects back from the Ticket
     * @return App\Project
     */
    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id')->first();
    }

    /**
     * user give one of User back from the Sprint
     * @return App\User
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->first();
    }

    /**
     * createdFrom give one of User back from the Sprint
     * @return App\User
     */
    public function createFrom()
    {
        return $this->hasOne('App\User', 'id', 'created_from')->first();
    }
}
