<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ]);
        $credentials = $request->only("username", "password");
        $user = auth()->attempt($credentials, $request->has("remember"));
        if ($user) {
            return redirect('/dashboard')->with("success", "Berhasil Login!!");
        } else {
            return redirect()->back()->with("error", "Gagal Login!!");
        }
    }
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/')->with("success", "Berhasil Logout!!");
    }
}
