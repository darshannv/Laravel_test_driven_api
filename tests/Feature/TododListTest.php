<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TodoList;
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

        $this->list = $this->createTodoList(['name' => 'my-list']);
    }

    public function test_fetch_all_todo_list(){
       //dd($list);
        $response = $this->getJson(route('todo-list.index'));

        //dd($reponse);

        $this->assertEquals(1, count($response->json()));

        $this->assertEquals('my-list', $response->json()[0]['name']);
    }


    public function test_fetch_single_todo_list() {

        $response = $this->getJson(route('todo-list.show', $this->list->id))
                    ->assertOk()
                    ->json();

        //$response->assertStatus(200);

       // $response->assertOk();
        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list(){

        $list = TodoList::factory()->make();

       $response = $this->postJson(route('todo-list.store', ['name' => $list->name]))
            ->assertCreated()
            ->json();

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


