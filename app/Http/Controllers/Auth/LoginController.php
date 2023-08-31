<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username_or_email';
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    protected function attemptLogin(Request $request)
    {
        $fieldType = filter_var($request->input('username_or_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return $this->guard()->attempt(
            [$fieldType => $request->input('username_or_email'), 'password' => $request->input('password')],
            $request->filled('remember')
        );
    }


}
