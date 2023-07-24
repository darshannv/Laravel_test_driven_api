<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TododListTest extends TestCase
{


    //Preparation / prepare

    //acion /perform

    //assertion / predict
    

    use RefreshDatabase;

    private $list;

    public function setUp(): void
    {
        parent::setUp();
        $user = $this->authUser();

        $this->list = $this->createTodoList([
            'name' => 'my-list',
            'user_id' => $user->id
        ]);
    }

    public function test_fetch_all_todo_list(){
       //dd($list);

        $this->createTodoList();
        $response = $this->getJson(route('todo-list.index'))->json('data');

        //dd($reponse);

        $this->assertEquals(1, count($response));

        $this->assertEquals('my-list', $response[0]['name']);
    }


    public function test_fetch_single_todo_list() {

        $response = $this->getJson(route('todo-list.show', $this->list->id))
                    ->assertOk()
                    ->json('data');

        //$response->assertStatus(200);

       // $response->assertOk();
        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list(){

        $list = TodoList::factory()->make();

       $response = $this->postJson(route('todo-list.store', ['name' => $list->name]))
            ->assertCreated()
            ->json('data');

            //dd($response['name']);
        $this->assertEquals($list->name, $response['name']);
            $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_while_storing_todo_list_name_field_is_required(){
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
                    //->assertStatus(422);
                    ->assertUnprocessable()
                    ->assertJsonValidationErrors(['name']);
    }


    public function test_delete_todo_list(){

        $this->deleteJson(route('todo-list.destroy', $this->list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);
    }

    public function test_update_todo_list(){

        $this->patchJson(route('todo-list.update', $this->list->id),['name' => 'updated name'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['id' => $this->list->id, 'name' => 'updated name']);
    }

    public function test_while_updating_todo_list_name_field_is_required(){
        $this->withExceptionHandling();

        $this->patchJson(route('todo-list.update', $this->list->id))
                    //->assertStatus(422);
                    ->assertUnprocessable()
                    ->assertJsonValidationErrors(['name']);
    }
}


