<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index() {
        $task = Task::all();
        return response($task);
    }

    public function store(Request $request){

        $task = Task::create($request->all());
        return response($task, 201);
    }

    public function destroy(Task $task) {

        $task->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Task $task, Request $request){
        $task->update($request->all());
        
        return response($task);
    }
}