<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers {
        login as signin;
        logout as signout;
    }

    /**
     * Where to redirect user after signing in
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('signout');

        $this->redirectTo = route('home');
    }
}
