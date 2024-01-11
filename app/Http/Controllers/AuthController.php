<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function index(){
        return view('');
    }


    public function login(Request $request){

        $validasi = $request->validate([
            "username" => "required",
            "password" => "required",
            "position" => "required",
        ]);

        if (Auth::attempt($validasi)) {
            if (Auth::user()->role == "admin") {
                return redirect('/admin')->with('success', 'Masuk berhasil!');
            }
            return redirect('/');
        }

        return redirect()->back()->with("error", "Gagal login");

    }


}
