<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\RoleUser;
use App\Role;

class UserTest extends TestCase
{
    /**
     * $user UserObject
     * @var App\User
     */
    private $user;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setUp(): void
    {
        parent::setUp();

        $role = Role::where('name', 'Admin')->first();
        $user = factory(\App\User::class)->make();
        $user->save();
        $user->attachRole($role);
        $this->user = $user;
    }

    /**
     * if check the Role User method in the User Model
     * @return void
     */
    public function testRoleUser()
    {
        $roleUser = RoleUser::where('user_id', $this->user->id)->first();
        $roleUserTemp = $this->user->roleUser();
        $this->assertEquals($roleUser, $roleUserTemp);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->user->delete();
    }
}
