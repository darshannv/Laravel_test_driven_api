<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Requests\LabelRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LabelResource;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends Controller
{
    

    public function index() {

        $label = auth()->user()->labels;
        return LabelResource::collection($label);
    }

    public function store(LabelRequest $request) {

        $label = auth()->user()->labels()->create($request->validated());
        return New LabelResource($label);
    }

    public function destroy(Label $label) {

        $label->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Label $label, LabelRequest $request) {

        $label->update($request->validated());
        //return response($label, Response::HTTP_OK);
        return new LabelResource($label);
    }
}
