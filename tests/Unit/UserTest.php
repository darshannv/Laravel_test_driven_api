<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_has_many_todo_lists()
    {
        
        $user = $this->authUser();
        $list = $this->createTodoList(['user_id' => $user->id]);

        $this->assertInstanceOf(TodoList::class, $user->todo_lists->first());
    }
}
