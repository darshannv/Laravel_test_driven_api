<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_todo_list_can_have_many_tasks()
    {
        $list = $this->createTodoList();
        $task =  $this->createTask(['todo_list_id' => $list->id]);

        $this->assertInstanceOf(Collection::class, $list->tasks);
        $this->assertInstanceOf(Task::class, $list->tasks->first());
    }

    public function test_id_todo_list_is_deleted_then_all_its_task_will_be_deleted(){

        $list = $this->createTodoList();

        $task = $this->createTask(['todo_list_id' => $list->id]);

        $task2 = $this->createTask();

        //action
        $list->delete();

        $this->assertDatabaseMissing('todo_lists', ['id' => $list->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
    }
}