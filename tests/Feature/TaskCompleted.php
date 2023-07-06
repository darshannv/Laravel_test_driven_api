<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCompleted extends TestCase
{

    use RefreshDatabase;
    
    public function test_a_task_status_can_be_changed()
    {
        $this->authUser();
        $task = $this->createTask();

        $this->patchJson(route('task.update', $task->id), ['status' => Task::NOT_STARTED]);

        $this->assertDatabaseHas('tasks', ['status' => Task::STARTED]);
    }
}
