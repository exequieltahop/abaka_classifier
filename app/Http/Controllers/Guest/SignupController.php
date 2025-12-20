<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function viewSignup()
    {
        return view('pages.guest.signup.index');
    }

    public function signupProcess(Request $request)
    {
        $request->validate([
            'fname',
            'mname',
            'lname',
            'username',
            'password',
        ]);
    }
}
