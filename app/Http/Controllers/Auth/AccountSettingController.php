<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AccountSettingController extends Controller
{
    public function index()
    {
        return view('pages.auth.account-setting.index', [
            'id' => Crypt::encrypt(Auth::user()->id)
        ]);
    }

    public function update(Request $request, string $id)
    {        
        $decrypted_id = Crypt::decrypt(urldecode($id));

        $request->validate([
            'fname' => 'required',
            'mname' => 'nullable',
            'lname' => 'required',
            'brgy' => 'required',
            'username' => ['required', 'unique:users,username,' . $decrypted_id],
            'password' => ['nullable', 'confirmed', 'min:8']
        ], [
            'required' => 'This field is required',
            'password.confirmed' => 'Password and confirmed password must be the same',
            'min' => 'Password must be atleast 8 characters long',
        ]);

        $update_data = [
            'fname' => $request->fname,
            'mname' => $request->mname ?? null,
            'lname' => $request->lname,
            'username' => $request->username,
            'brgy' => $request->brgy
        ];

        if ($request->filled('password')) $update_data['password'] = Hash::make($request->password);

        $user = User::findOrFail($decrypted_id);

        $update_status = $user->update($update_data);

        if (!$update_data) return response()->json([], 500);

        return response()->json([]);
    }
}
