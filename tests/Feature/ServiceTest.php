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
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')->andReturn(['access_token' =>'fake-token']);
        });

        $res = $this->postJson(route('service.callback'), [
            'code' => 'dummyCode'
        ])->assertCreated();


        $this->assertDatabaseHas('web_services', ['user_id' => $this->user->id,
        'token' => json_encode(['access_token' => 'fake-token'])
    ]);

        //$this->assertNotNull($this->user->services->first()->token);
    }

    public function test_data_of_a_week_can_be_stored_on_google_drive() {

        $this->createTask(['created_at' => now()->subDays(2)]);
        $this->createTask(['created_at' => now()->subDays(4)]);
        $this->createTask(['created_at' => now()->subDays(3)]);
        $this->createTask(['created_at' => now()->subDays(6)]);
        $this->createTask(['created_at' => now()->subDays(10)]);

        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('setAccessToken');
            $mock->shouldReceive('getLogger->info');
            $mock->shouldReceive('shouldDefer');
            $mock->shouldReceive('execute');
        });

        $web_service = $this->CreateWebService();
        $this->postJson(route('web-service.store', $web_service->id))->assertCreated();
    }
}
