<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_user_can_register()
    {
    
        $this->postJson(route('user.register', [
            'name' => 'test', 
            'email' => 'test@mail.com', 
            'password' => 'secret123',
            'password_confirmation' => 'secret123']))
                ->assertCreated();

        $this->assertDatabaseHas('users', ['name' => 'test']);
    }
}
