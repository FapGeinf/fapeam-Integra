<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'cpf';
    }


    public function sendFailedLoginResponse(Request $request)
    {
        $username = $this->username();

        $user = User::where($username, $request->input('cpf'))->first();

        if (!$user) {
            return redirect()->back()
                ->withInput($request->only('cpf'))
                ->withErrors([
                    $username => 'Usuário não cadastrado ou inexistente.'
                ]);
        }

        return redirect()->back()
            ->withInput($request->only('cpf'))
            ->withErrors([
                'password' => 'Senha incorreta.'
            ]);
    }
}
