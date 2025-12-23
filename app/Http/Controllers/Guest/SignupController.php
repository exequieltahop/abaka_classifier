<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function viewSignup()
    {
        return view('pages.guest.signup.index');
    }

    /**
     * process sign up
     * 
     * validate payload
     * create new user
     * log in new user
     * return response 200
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function signupProcess(Request $request): JsonResponse
    {
        // dd($request->all());
        $request->validate([
            'fname' => 'required',
            'mname' => 'nullable',
            'lname' => 'required',
            'brgy' => 'required',
            'username' => ['required', 'unique:users,username'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'required' => 'This field is required',
            'password.confirmed' => 'Password and confirmed password must be the same',
            'min' => 'Password must be atleast 8 characters long',
        ]);

        $new_user = User::create([
            'fname' => $request->fname,
            'mname' => $request->mname ?? null,
            'lname' => $request->lname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 3,
            'brgy' => $request->brgy
        ]);

        Auth::login($new_user);

        return response()->json([]);
    }
}
