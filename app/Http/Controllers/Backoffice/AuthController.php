<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('backoffice.login');
    }

    public function postLogin(Request $request)
    {
        $rules = array(
            'email' => 'required|email|max:100|min:5',
            'password' => 'required|string|max:42|min:4'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('login')->with('message', $validator->messages()->first());
        } else {
            $email = $request->email;
            $password = $request->password;

            // User::create([
            //     'name' => 'Admin',
            //     'email' => $request->email,
            //     'password' => bcrypt($request->password),
            // ]);
            if(Auth::attempt([
                'email' => $email,
                'password' => $password,
                'status' => 'active',
            ])){
                return redirect('app');
            }else{
                if(User::where('email', $email)->count() > 0 )
                    return redirect()->back()->with("message","Akun Anda dinonaktifkan.");
                return redirect()->back()->with("message","Username atau password salah.");
            }
        }
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        
        return redirect()->route('login');
    }
}
