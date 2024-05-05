<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Project;
use App\Ticket;
use App\Http\Requests\TicketEditRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TicketEditRequestTest extends TestCase {

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
     * $ticket TicketObject
     * @var sts\Ticket
     */
    private $ticket;

    /**
     * setup is the construct method and is fill all Variable with the right Opject
     */
    public function setUp(): void
    {
        parent::setUp();
        $role = Role::where('name', 'Teamleader')->first();
        $this->user = factory(\App\User::class)->make();
        $this->user->save();
        $this->user->attachRole($role);

        $this->project = factory(\App\Project::class)->make();
        $this->project->method = 'Scrum';
        $this->project->save();

        $this->ticket = factory(\App\Ticket::class)->make();
        $this->ticket->project_id = $this->project->id;
        $this->ticket->created_from = $this->user->id;
        $this->ticket->save();
    }

    /**
     * Test the RequestObject The field name
     * @return void
     */
    public function testRequestTicket() {
        $this->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 'High',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(422);

        $this->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicketphpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 'High',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket1',
                'description' => 'phpunitDescription1',
                'status' => 'ToDo',
                'priority' => 'High',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(200);

        Ticket::where('name','phpunitTicket1')->first()->delete();
    }

    /**
     * Test the RequestObject The field description
     * @return void
     */
    public function testRequestDescription() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'status' => 'ToDo',
                'priority' => 'High',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field status
     * @return void
     */
    public function testRequestStatus() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'priority' => 'High',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(422);
    }


    /**
     * Test the RequestObject The field priority
     * @return void
     */
    public function testRequestPriority() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'storyPoints' => '2',
                'project' => $this->project->name,
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field Story Points
     * @return void
     */
    public function testRequestStoryPoints() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 1,
                'project' => $this->project->name,
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 1,
                'storyPoints' => 'test',
                'project' => $this->project->name,
            ])->assertStatus(422);
    }

    /**
     * Test the RequestObject The field project
     * @return void
     */
    public function testRequestProject() {
        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 'High',
                'storyPoints' => '2',
            ])->assertStatus(422);

        $this->followingRedirects()->actingAs($this->user)
            ->json('POST', "/ticket/edit/".$this->ticket->ext_id, [
                'name' => 'phpunitTicket',
                'description' => 'phpunitDescription',
                'status' => 'ToDo',
                'priority' => 'High',
                'project' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
            ])->assertStatus(422);
    }

    /**
     * tearDown is the destruct method and delete all Variable
     */
    public function tearDown(): void
    {
        $this->ticket->delete();
        $this->project->delete();
        $this->user->delete();
    }
}
