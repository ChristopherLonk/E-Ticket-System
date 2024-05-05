<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'method','ext_id'];

    /**
     * all active is search in Project table where is_delete = NULL
     * @return array
     */
    static function allActive()
    {
        return parent::where('is_delete', null)->get();
    }

    /**
     * all scrum and active is search in Project table where is_delete = NULL and is method = scrum
     * @return array
     */
    static function allScrumAndActive()
    {
        return parent::where('method', 'Scrum')->where('is_delete', null)->get();
    }

    /**
     * Sprint give back all Sprints from the Project
     * @return App\Sprint
     */
    public function sprint()
    {
        return $this->hasMany('App\Sprint')->get();
    }

    /**
     * Ticekt give back all Tickets from the Project
     * @return App\Ticket
     */
    public function ticket()
    {
        return $this->hasMany('App\Ticket')->get();
    }
}
