<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * index
     */
    public function index(): View
    {
        $sort_date = urldecode(request('sort_date'));
        $sort_name = urldecode(request('sort_name'));
        $search = request('search');

        $query = User::whereNot('role', 1);

        if (!empty($sort_date)) $query->orderBy('created_at', $sort_date);
        if (!empty($sort_name)) $query->orderBy('name', $sort_name);
        if (!empty($search)) $query->where(function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%")
                ->OrWhere('email', 'like', "%$search%");
        });

        $data = $query->paginate(15)->withQueryString();

        foreach ($data as $item) {
            $item->encrypted_id = Crypt::encrypt($item->id);
        }

        return view('pages.auth.users.index', [
            'data' => $data
        ]);
    }

    /**
     * create
     */
    public function create(): View
    {
        return view('pages.auth.users.create');
    }

    /**
     * store
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'min:8']
        ]);

        $create = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2
        ]);

        if (!$create) {
            session()->flash('error', "Server Error");
            return redirect()->route('users.index');
        }

        session()->flash('success', "Successfully Create Account");
        return redirect()->route('users.index');
    }

    /**
     * destroy
     */
    public function destroy(string $id)
    {
        $decrypted_id = Crypt::decrypt(urldecode($id));

        $user =  User::findOrFail($decrypted_id);

        $delete = $user->delete();

        if (!$delete) return response()->json([], 500);

        return response()->json([], 200);
    }

    /**
     * edit
     */
    public function edit(string $id)
    {
        $decrypted_id = Crypt::decrypt(urldecode($id));

        $user = User::findOrFail($decrypted_id);

        $user->encrypted_id = Crypt::encrypt($user->id);

        return view('pages.auth.users.edit', ['data' => $user]);
    }

    /**
     * update
     */
    public function update(string $id, Request $request)
    {
        $decrypted_id = Crypt::decrypt(urldecode($id));

        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', "unique:users,email,$decrypted_id"],
            'new_password' => ['nullable', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'min:8']
        ]);

        $user = User::findOrFail($decrypted_id);

        if ($request->filled('new_password')) {
            $update = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->new_password)
            ]);
        } else {
            $update = $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        if (!$update) {
            session()->flash('error', 'Server Error');
            return redirect()->route('users.index');
        }

        session()->flash('success', 'Successfully Updated User');
        return redirect()->route('users.index');
    }
}
