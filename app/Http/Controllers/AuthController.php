<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{

    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|integer' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if($user->role == 1){
            $user->assignRole('admin');
        }else{
            $user->assignRole('user');
            $pelanggan = Pelanggan::create([
                'user_id' => $user->id,
            ]);
        }
        

        return redirect('/login')->with('success','Registrasi berhasil silahkan login');
    }

    // public function RegisterAdmin(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|unique:users,email',
    //         'password' => 'required|string|min:6'
    //     ]);

    //     $user = Admin::create([
    //         'name' => $request->name,
    //         'password' => bcrypt($request->password),
    //         'email' => $request->email, 
    //     ]);

    //     $user->assignRole('admin');

    //     return redirect('/login')->with('success','Registrasi berhasil silahkan login');
    // }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
       
            $request->session()->regenerate();

            if(auth()->user()->hasRole('admin')){
                return redirect()->intended('/admin')->with('success','Login berhasil');
            }else{
                return redirect()->intended('/dashboard')->with('success','Login berhasil');
            }
        }
        
    }

    public function Logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}