<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Routing\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_fetch_all_tasks_of_a_todo_list()
    {
        $list = $this->createTodoList();
        //Preparation
        $task = $this->createTask();

        //action
        $response = $this->getJson(route('todo-list.task.index', $list->id))->assertOk()->json();

        //assertion
        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
    }


    public function test_store_a_task_for_todo_list(){


        $list = $this->createTodoList();

        $task = $this->createTask();

        $this->postJson(route('todo-list.task.store', $list->id), ['title' => $task->title])
            ->assertCreated();

        
        $this->assertDatabaseHas('tasks', ['title' => $task->title]);
        
    }

    public function test_delete_a_task_from_database(){

        $task = Task::factory()->create();

        $this->deleteJson(Route('task.destroy', $task->id))->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
    }

    public function test_update_a_task_of_a_todo_list(){


        $task = $this->createTask();

        $this->patchJson(Route('task.update', $task->id), ['title' => 'Updated title'])
            -> assertOk();

        $this->assertDatabaseHas('tasks', ['title' => 'Updated title']);
    }
}
