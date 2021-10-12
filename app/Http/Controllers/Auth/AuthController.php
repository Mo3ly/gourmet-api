<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function __invoke(Request $request){      
        $credentials = $request->only('email', 'password');

        if(! auth()->attempt($credentials)){
            throw ValidationException::withMessages([
                // 'email' => 'Invalid credentials'
                'Invalid credentials'
            ]);
        }

        $request->session()->regenerate();

        return response()->json(null ,201);
    }

    public function register(Request $request){

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // return response()->json(null ,201);
        //return $user;
    }

    public function logout(Request $request){
        auth()->guard('web')->logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        $request->json(null, 200);
    }
}
