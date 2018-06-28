<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\RoleUser;
use App\Tools;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller {

    /**
     * Check if User Auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Give back the View with all User
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('layouts/user/index', ['users' => User::all()]);
    }

    /**
     * Give back the View
     * @return \Illuminate\View\View
     */
    public function createGet() {
        return view('layouts/user/create');
    }
    /**
     * Create a new User and check if validate of the Object UserRequest and go back to the Index method
     * @param  UserRequest $request
     * @return \Illuminate\view\View  Get the view from the index method
     */
    public function createPost(UserRequest $request) {
        $randomByte = Tools::randomByte();

        while(!empty(User::where('ext_id', $randomByte)->first())){
            $randomByte = Tools::randomByte();
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'ext_id' => $randomByte
        ];

        $role = Role::where('name', $request->input('role'))->first();
        if (!empty($role)) {
            $user = new User();
            $user->fill($data)->save();
            $user->attachRole($role);
        }
        return $this->index();
    }

    /**
     * Give back the View
     * @param  string $extId extern id
     * @return \Illuminate\view\View
     */
    public function editGet(string $extId) {
        return view('layouts/user/edit', ['user' => User::where('ext_id',$extId)->first()]);
    }

    /**
     * edit a User and check if validate of the Object UserRequest and go back to the Index method
     * @param  string $extId
     * @param  UserEditRequest $request
     * @return \Illuminate\view\View  Get the view from the index method
     */
    public function editPost(string $extId, UserEditRequest $request) {
        $user = User::where('ext_id', $extId)->first();
        if (!empty($request->input('name')) && !empty($request->input('email')) && !empty($request->input('role'))) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            RoleUser::allRoleDeleteByUserId($user->id);
            foreach (Role::all() as $key => $role) {
                if ($role->name == $request->input('role')) {
                    $roleId = $role->id;
                }
            }
            $role = Role::find($roleId);
            $user->attachRole($role);
            if (!empty($request->input('name')) && !empty($request->input('name')) && $request->input('name') == $request->input('name')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
        }
        return $this->index();
    }

    /**
     * delete the Right user and go back to the Index method
     * @param  string $extId
     * @return \Illuminate\view\View  Get the view from the index method
     */
    public function delete(string $extId) {
        User::where('ext_id',$extId)->delete();
        return $this->index();
    }

}
