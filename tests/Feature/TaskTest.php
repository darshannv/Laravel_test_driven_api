<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_fetch_all_tasks_of_a_todo_list()
    {
        //Preparation
        $task = Task::factory()->create();

        //action
        $response = $this->getJson(route('task.index'))->assertOk()->json();

        //assertion
        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
    }
}
