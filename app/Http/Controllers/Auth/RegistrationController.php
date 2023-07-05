<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegistrationController extends Controller
{
    

    public function __invoke(RegisterRequest $request) 
    {
        $user = User::create($request->validated());

        return $user;
    }
}
