<?php

namespace Tests\Feature;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserTest extends TestCase {

    /**
     * $user is a User Object
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
     * Test the index method from UserController with user and no user
     * @return void
     */
     public function testIndex() {
        $this->get('/user')
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get('/user')
            ->assertSuccessful()
            ->assertViewIs('layouts.user.index')
            ->assertSee('New User');
    }

    /**
     * Test the Create method from UserController with user and no user
     * @return void
     */
    public function testCreateGet() {
        $this->get('/user/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->get('/user/create')
            ->assertSuccessful()
            ->assertViewIs('layouts.user.create')
            ->assertSee('Role');
    }

    /**
     * Test the Edit method from UserController with user and no user
     * @return void
     */
    public function testEditGet() {

        $role = Role::where('name', 'User')->first();
        $user = factory(\App\User::class)->make();
        $user->save();
        $user->attachRole($role);


        $this->get("/user/edit/".$user->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->get("/user/edit/".$user->ext_id)
            ->assertSuccessful()
            ->assertViewIs('layouts.user.edit')
            ->assertSee($user->email)
            ->assertSee($user->name);

        $user->delete();
    }

    /**
     * Test the Delete method from UserController with user and no user
     * @return void
     */
    public function testDeleteGet() {
        $this->get("/user/delete/".$this->user->ext_id)
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->actingAs($this->user)
            ->get("/user/delete/".$this->user->ext_id)
            ->assertSuccessful();
    }

    /**
     * Test the Create method from UserController with user and no user
     * @return void
     */
    public function testCreatePost() {
        $this->json('POST', '/user/create', [
            'name' => 'phpUnitUser',
            'email' => 'phpUnitUser1@example.de',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
            'role' => 'user'
        ])->assertStatus(401);

        $this->actingAs($this->user)
            ->json('POST', '/user/create', [
                'name' => 'phpUnitUser',
                'email' => 'phpUnitUser2@example.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'user'
            ])->assertStatus(200);
        User::where('email', 'phpUnitUser2@example.de')
            ->first()
            ->delete();
    }

    /**
     * Test the Edit method from UserController with user and no user
     * @return void
     */
    public function testEditPost() {
        $this->json('POST', "/user/edit/".$this->user->ext_id, [
            'name' => 'phpUnitAdmin',
            'email' => 'phpUnitAdmin@example.de',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
            'role' => 'admin'
        ])->assertStatus(401);

        $this->actingAs($this->user)
            ->json('POST', '/user/edit/' . $this->user->ext_id, [
                'name' => 'phpUnitAdmin',
                'email' => 'phpUnitAdmin@example.de',
                'password' => 'testtest',
                'password_confirmation' => 'testtest',
                'role' => 'admin'
            ])->assertStatus(200);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(){
        $this->user->delete();
    }
}
