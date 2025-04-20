<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['massage'=> 'Email or password is incorrect']);
        }
//        return response('great!');
        return redirect('/');
    }

}
