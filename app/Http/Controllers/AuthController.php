<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request) {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function login_action(Request $request) {
        $validator = $request->validate([
            'email' => 'required|email',
            'password' =>'required|min:6'
        ]);

        if (Auth::attempt($validator)) {
            return redirect(route('home'));
        }
    }

    public function register(Request $request) {
        $isLoggedIn = Auth::check();
        if ($isLoggedIn) {
            return redirect()->route('home');
        }

        return view('register');
    }

    public function register_action(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        User::create($data);

        return redirect(route('login'));
    }

    public function logout (Request $request) {
        Auth::logout();
        return redirect(route('login'));
    }

}
