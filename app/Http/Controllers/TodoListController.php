<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoListResource;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index(){

        $lists = auth()->user()->todo_lists;
        //TodoList::whereUserId(auth()->id())->get();
        //return response($lists);
        return TodoListResource::collection($lists);
    }

    public function show(TodoList $todo_list){
        
        //$todo_list = TodoList::findorFail($todolist);
        return new TodoListResource($todo_list);
    }


    public function store(TodoListRequest $request){
        // $todo_list = TodoList::create($request->all());
        // return response($todo_list, Response::HTTP_CREATED);


        $todo_list = auth()->user()->todo_lists()->create($request->validated());

        return new TodoListResource($todo_list);
    }

    public function destroy(TodoList $todo_list){

        $todo_list->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(TodoList $todo_list, TodoListRequest $request){

        $todo_list->update($request->all());
        return new TodoListResource($todo_list);
    }
}