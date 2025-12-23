<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Menampilkan Form Register Organizer (Creator)
    public function showOrganizerRegisterForm()
    {
        return view('auth.register-organizer');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username'  => ['required', 'string', 'alpha_dash', 'max:255', 'unique:users'],
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'      => ['nullable', 'string', 'in:user,organizer'], // Validasi input role
            'password'  => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);
    }

    protected function create(array $data)
    {
        // Deteksi role dari input hidden, default ke 'user'
        $roleSlug = $data['role'] ?? 'user';
        $role = Role::where('slug', $roleSlug)->first();

        return User::create([
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role_id'   => $role->id,
        ]);
    }

    /**
     * Override method registered dari trait RegistersUsers
     * Untuk mengatur redirect setelah sukses mendaftar
     */
    protected function registered(Request $request, $user)
    {
        if ($user->hasRole('organizer')) {
            return redirect()->route('organizer.dashboard')
                ->with('success', 'Akun Creator berhasil dibuat!');
        }

        return redirect($this->redirectPath())
            ->with('success', 'Selamat datang di EventLyfe!');
    }
}
