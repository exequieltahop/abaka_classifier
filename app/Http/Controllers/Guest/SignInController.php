<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SignInController extends Controller
{
    public function index() {
        try {
            return view('pages.guest.signin.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500);
        }
    }

    // process signin
    public function processSignin(Request $request) {
        // validate
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        // if failed to authenticate then response 401
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember_me'))){
            return response(null, 401);
        }

        // response 200
        return response(null, 200);
    }

    // sign ou
    public function signout() {
        Auth::logout();

        return redirect()->route('home');
    }
}
