<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'password' => 'required|min:3|max:255',
        ]);
        
        // check apakah pass1 dan pass2 cocok
        if($request->input('password') == $request->input('password2'))
        {
            // checking, apakah username telah ada atau belum 
            $users = User::where('name', '=', $request->input('name'))->first();
            if ($users === null) 
            {
                $validatedData['password'] = Hash::make($validatedData['password']);

                User::create([
                    'name' => $validatedData['name'],
                    'password' => $validatedData['password'],
                    'roles' => "USER"
                ]);
        
                $request->session()->flash('success', 'Registration Successfull');
        
                return redirect()->route('login');
            } 
            else 
            {
                $request->session()->flash('failed', 'Sorry Your Username Has been Already');
        
                return redirect()->route('register');
            }
        }
        else
        {
            $request->session()->flash('failed', 'Sorry Your Password Not Match');
            return redirect()->route('register');
        }

    }
}
