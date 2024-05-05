<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sprint';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['project_id','name','from', 'to','ext_id'];

    /**
     * delet all Sprints by Project id from the Sprint table
     * @param  int $id
     * @return void
     */
    static function deleteAllSprintsByProjectId(int $id)
    {
        $sprints = Sprint::where('project_id', $id)->get();
        foreach ($sprints as $key => $sprint) {
            $sprint->delete();
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
     * Project give one of Projects back from the Sprint
     * @return App\Project
     */
    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id')->first();
    }

    /**
     * ticket give back all Tickets from the Sprint
     * @return App\Ticket
     */
    public function ticket()
    {
        return $this->hasMany('App\Ticket')->get();
    }
}
