<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Str;
use App\Notifications\UserCreated;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('admin.create-user');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit-user')->with('user', $user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string']
        ]);
        $random = Str::random(10);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($random),
            'role' => $request->role
        ]);
        if($user) {
            $user->notify(new UserCreated($user->email, $random));
            return redirect('/home')->with(['type' => 'success', 'msg' => 'Uspešno ste dodali novog korisnika.']);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id.',id'],
            'password' => ['sometimes', 'nullable', 'min:8']
        ]);
        if($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }
        return redirect('/home')->with(['type' => 'success', 'msg' => 'Uspešno ste izmenili svoje podatke.']);
    }
}
