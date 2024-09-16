<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function registerUser()
    {
        return view('auth.userregister');
    }

    public function registerAuthor()
    {
        return view('auth.authorregister');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function store($type = null, Request $request): RedirectResponse
    {
        $validated = Validator::make($request->all(), [
            'inputName' => 'required',
            'inputLName' => 'required',
            'inputEmail' => 'required|email|unique:users,email',
            'inputPassword' => 'required|min:8|max:25|confirmed',
            'inputPhone' => 'nullable|numeric|digits_between:8,10',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $user = User::create([
            'first_name' => $request->input('inputName'),
            'last_name' => $request->input('inputLName'),
            'email' => $request->input('inputEmail'),
            'address' => $request->input('inputAddress') ?? null,
            'phone' => $request->input('inputPhone') ?? null,
            'gender' => $request->input('inputGender') ?? null,
            'password' => Hash::make($request->input('inputPassword')),
            'genres' => $request->input('genres') ? json_encode($request->input('genres')) : json_encode([]),
            'bio' => $request->input('bio') ?? null
        ]);

        if ($type === 'author') {
            $user->assignRole('author');
        } elseif ($type === 'viewer') {
            $user->assignRole('viewer');
        }

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registration Successful.');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors([
                'password' => 'The provided password is incorrect.',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function profile()
    {
        return view('profile');
    }
}
