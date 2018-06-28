<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRequestTest extends TestCase {

    /**
     * $user UserObject
     * @var App\User
     */
    private $user;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setUp()
    {
        parent::setUp();
        $role = Role::where('name', 'Admin')->first();
        $user = factory(\App\User::class)->make();
        $user->save();
        $user->attachRole($role);
        $this->user = $user;
    }

    /**
     * Test the RequestObject The field Email
     * @return void
     */
    public function testRequestEmail() {
        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'email' => 'test.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'email' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest@testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'email' => 'test@test.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'User'
            ])->assertStatus(200);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'email' => 'test@test.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'User'
            ])->assertStatus(422);
        User::where('email','test@test.de')->first()->delete();
    }

    /**
     * Test the RequestObject The field name
     * @return void
     */
    public function testRequestName() {
        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttestde',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field password
     * @return void
     */
    public function testRequestPassword() {
        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testt',
                'password_confirmation' => 'testtest',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testt',
                'password' => 'test',
                'password_confirmation' => 'testtest',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field passwordConfirmation
     * @return void
     */
    public function testRequestPasswordConfirmation() {
        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testt',
                'password' => 'testtest',
                'password_confirmation' => 'testtet',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testt',
                'password' => 'test',
                'email' => 'phpunit@phpunit.de',
                'role' => 'User'
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field Role
     * @return void
     */
    public function testRequestRole() {
        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'testt',
                'password' => 'test',
                'email' => 'phpunit@phpunit.de'
            ])->assertStatus(422);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(){
        $this->user->delete();
    }

}
