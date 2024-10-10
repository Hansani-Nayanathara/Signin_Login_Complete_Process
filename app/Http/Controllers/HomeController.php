<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function signin(){
        return view('signin');
    }

    public function login(){
        return view('login');
    }

    public function profile(){
        $userName = auth()->user()->name;
        $userAdd = auth()->user()->address;
        return view('profile', compact('userName','userAdd'));
    }

    public function store(Request $request){

        $rules = [
            'username' => 'required|string|max:200',
            'address' => 'required|string|max:200',
            'mobile_nu' => 'required|string|min:10|max:15',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/'
            ]
        ];

        $messages = [
            'password.regex'=>'The password must contain at least one simple, one capital, one number and one symbol.'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

            $user = new User();
            $user->name = $request->username;
            $user->address = $request->address;
            $user->mobile_nu = $request->mobile_nu;
            $user->password = $request->password;
            $user->save();

            return redirect()->route('login')->with('success','User registered successfully');
    }

    public function loginProcess(Request $request){
        $credentials = $request->only('name','password');

        if (Auth::attempt($credentials)){
            return redirect()->intended('profile');
        }

        return redirect()->route('login')->with('error','Invalid credentials');
    }
}
