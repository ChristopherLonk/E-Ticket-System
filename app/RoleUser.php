<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_user';

    /**
     * role give back all role from the RoleUser
     * @return App\Role
     */
    public function role(){
        return $this->hasMany('App\Role', 'id', 'role_id')->first();
    }

    /**
     * user give back all user from the RoleUser
     * @return App\User
     */
    public function user(){
        return $this->hasMany('App\User', 'id', 'user_id')->get();
    }

    /**
     * delet all roles from the User
     * @param  int $id
     * @return void
     */
    static function allRoleDeleteByUserId(int $id){
        $roles = Parent::where('user_id', $id)->get();
        foreach ($roles as $key => $role) {
            $role->delete();
        }
    }
}
