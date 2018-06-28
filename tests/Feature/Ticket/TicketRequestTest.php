<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Project;
use App\Ticket;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TicketRequestTest extends TestCase {

    /**
     * $user UserObject
     * @var App\User
     */
    private $user;

    /**
     * $project ProjectObject
     * @var App\Project
     */
    private $project;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setUp()
    {
        parent::setUp();
        $role = Role::where('name', 'Teamleader')->first();
        $this->user = factory(\App\User::class)->make();
        $this->user->save();
        $this->user->attachRole($role);

        $this->project = factory(\App\Project::class)->make();
        $this->project->method = 'Scrum';
        $this->project->save();
    }

    /**
     * Test the RequestObject The field name
     * @return void
     */
    public function testRequestTicket() {
        $this->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'description' => 'phpunitDescription',
                'project' =>  $this->project->name,
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicket',
                'description' => 'phpunitDescription',
                'project' =>  $this->project->name,
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'project' => $this->project->name,
            ])->assertStatus(200);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'project' =>  $this->project->name,
            ])->assertStatus(422);

        Ticket::where('name','phpunitTicket')->first()->delete();
    }

    /**
     * Test the RequestObject The field descrition
     * @return void
     */
    public function testRequestDescription() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicket',
                'project' => $this->project->name,
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field project
     * @return void
     */
    public function testRequestProject() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', '/ticket/create', [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'project' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
            ])->assertStatus(422);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(){
        $this->project->delete();
        $this->user->delete();
    }
}
