<?php

namespace Tests\Feature;

use Google\Client;
use Tests\TestCase;
use App\Models\WebService;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{

    use RefreshDatabase;

    private $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }

    public function test_a_user_can_connect_to_a_service_and_token_is_stored()
    {

        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('setScopes')->once();
            $mock->shouldReceive('createAuthUrl')->andReturn('http://127.0.0.1');
        });


        $response = $this->getJson(route('service.connect','google-drive'))
                ->assertOk()
                ->json();

        $this->assertEquals('http://127.0.0.1', $response['url']);
        $this->assertNotNull($response['url']);
    }



    public function test_service_callback_will_store_token() {

        $this->mock(Client::class, function (MockInterface $mock) {
            // $mock->shouldReceive('setClientId')->once();
            // $mock->shouldReceive('setClientSecret')->once();
            // $mock->shouldReceive('setRedirectUri')->once();
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')->andReturn('fake-token');
        });

        $res = $this->postJson(route('service.callback'), [
            'code' => 'dummyCode'
        ])->assertCreated();


        $this->assertDatabaseHas('web_services', ['user_id' => $this->user->id,
        'token' => '{"access_token":"fake-token"}'
    ]);

        //$this->assertNotNull($this->user->services->first()->token);
    }
}
