<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showRegisterFormCustomer()
    {
        $genders = Common::option('gender');
        $roles = Role::all();
        return view('frontend.auth.customer.register', [
            'roles' => $roles,
            'genders' => $genders,
        ]);
    }

    public function registerCustomer(CustomerRequest $request)
    {
        $title = 'Customer';
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole('customer');
        return Redirect::route('landing.index')->with('success', __('message.create_customer_success', ['label' => __($title)]));
    }

    public function showLoginFormCustomer()
    {
        return view('frontend.auth.customer.login');
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->route('landing.index')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah',
        ])->with('sweetalert', true);
    }


    public function showLoginForm()
    {
        return view('frontend.auth.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required|string'
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($loginType, $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            if ($user->role === 'admin' || $user->role === 'customer') {
                return redirect()->intended('/dashboard')->with('success', 'Selamat Datang Kembali!');
            }
        }
        return back()->withErrors([
            'login' => 'Login atau Password salah',
        ])->with('sweetalert', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


    public function logoutCustomer(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('landing.index')->with('success', 'Anda telah Logout!');
    }
}
