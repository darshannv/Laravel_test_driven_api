<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Http\Requests\TodoListRequest;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index(){

        $lists = auth()->user()->todo_lists;
        //TodoList::whereUserId(auth()->id())->get();
        return response($lists);
    }

    public function show(TodoList $todo_list){
        
        //$todo_list = TodoList::findorFail($todolist);
        return response($todo_list);
    }


    public function store(TodoListRequest $request){
        // $todo_list = TodoList::create($request->all());
        // return response($todo_list, Response::HTTP_CREATED);

        return auth()->user()->todo_lists()->create($request->validated());
    }

    public function destroy(TodoList $todo_list){

        $todo_list->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(TodoList $todo_list, TodoListRequest $request){

        $todo_list->update($request->all());
        return $todo_list;
    }
}