<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\User;
use App\roleUser;
use App\Role;

class RoleUserTest extends TestCase {

    /**
     * If check the RoleObject = Role::find($roleUser->role_id)
     * @return void
     */
    public function testRole() {
        $roleUsers = RoleUser::inRandomOrder()->get();
        foreach ($roleUsers as $key => $roleUser) {
            $roleTemp = Role::find($roleUser->role_id);
            $role = $roleUser->role();
            $this->assertEquals($role, $roleTemp);
        }
    }

    /**
     * If check the UserObject = User::find($roleUser->user_id)
     * @return void
     */
    public function testUser() {
        $roleUsers = RoleUser::inRandomOrder()->get();
        foreach ($roleUsers as $key => $roleUser) {
            $user = User::find($roleUser->user_id);
            $userTemp = $roleUser->user()->first();
            $this->assertEquals($user, $userTemp);
        }
    }

    /**
     * Test the method AllRoleDeleteByUserId
     * @return void
     */
    public function testAllRoleDeleteByUserId() {
        $roleUser = RoleUser::inRandomOrder()->first();
        $role = $roleUser->role();
        $user = $roleUser->user()->first();
        RoleUser::allRoleDeleteByUserId($user->id);

        $this->assertTrue(is_null(RoleUser::where('user_id', $user->id)->first()));
        $user->attachRole($role);
    }

}
