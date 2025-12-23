<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/home';

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
        $login = request()->input('login');

        // Cek apakah input adalah email yang valid
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Gabungkan input ke request agar Laravel mencari di kolom yang benar
        request()->merge([$field => $login]);

        return $field;
    }

    /**
     * Override fungsi validateLogin untuk menyesuaikan dengan field 'login'
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Ambil kredensial yang dibutuhkan untuk login
     */
    protected function credentials(Request $request)
    {
        $field = $this->username();
        return [
            $field     => $request->get($field),
            'password' => $request->get('password'),
        ];
    }

    protected function authenticated(Request $request, $user)
    {
        return match ($user->role->slug) {
            'admin'     => redirect()->route('admin.dashboard'),
            'organizer' => redirect()->route('organizer.dashboard'),
            'checker'   => redirect()->route('checker.dashboard'),
            default     => redirect()->route('home'),
        };
    }
}
