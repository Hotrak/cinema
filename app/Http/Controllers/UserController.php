<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {

    }

    public function store(RegisterRequest $authRequest)
    {
        $validated = $authRequest->validated();
        if ($validated->fails())
        {
            return response(['errors'=>$validated->errors()->all()], 422);
        }


        $authRequest['password']=Hash::make($authRequest->password);
        $user = User::create($authRequest->all(['name','email','phone','password']));
        auth()->login($user);
        return json_encode($user);
    }
    public function login(){

        if(!auth()->attempt(request(['email','password'])))
        {
            $response = "Не верно введён логин или пароль";
            return response($response, 422);
        }

        $user = auth()->user();
        $user->hasRole('admin');
        return json_encode($user);
    }
    public function destroy(){
        auth()->logout();
        return 'OK';
    }
}
