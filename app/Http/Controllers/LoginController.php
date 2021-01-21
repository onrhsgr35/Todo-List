<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login() {
        return view('login');
    }
    public function Register() {
        return view('register');
    }
}
