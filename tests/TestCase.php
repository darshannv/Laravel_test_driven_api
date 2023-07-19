<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use App\Models\TodoList;
use App\Models\WebService;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void {

        parent::setUp();
        $this->withoutExceptionHandling();

    }

    public function createTodoList($args = []){
        return TodoList::factory()->create($args);
    }

    public function createTask($args = []) {

        return Task::factory()->create($args);
    }

    public function Createuser($args = []) {

        return User::factory()->create($args);
    }

    public function authUser() {
        $user = $this->Createuser();
        Sanctum::actingAs($user);
        return $user;
    }

    public function CreateLabel($args = []) {

        return Label::factory()->create($args);
    }

    public function CreateWebService($args = []) {

        return WebService::factory()->create($args);
    }
}