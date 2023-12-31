<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(TodoList $todo_list) {

        //$task = Task::where(['todo_list_id' => $todo_list->id])->get();
        $task = $todo_list->tasks;
        return TaskResource::collection($task);
    }

    public function store(TaskRequest $request, TodoList $todo_list){

        //$task = $todo_list->tasks()->create($request->all());

        // $request['todo_list_id'] = $todo_list->id;

        // $task = Task::create($request->all());
       // return response($task, 201);
       $task = $todo_list->tasks()->create($request->validated());
        return new TaskResource($task);
    }

    public function destroy(Task $task) {

        $task->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Task $task, Request $request){
        $task->update($request->all());
        
        return new TaskResource($task);
    }
}