<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    /**
    * Test the Index method from HomeController no Auth user
    * @return void
     */
    public function testIndex()
    {
        $this->get('/')
            ->assertSuccessful()
            ->assertViewIs('layouts.home.index')
            ->assertSee('Welcome to a E-Ticket System');
    }
}
