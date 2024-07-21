<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // public function index(){
    //     $client = Auth::guard('client')->user();
    //     return view('livewire.client.index', compact('client'));
    // }

    public function login(Request $request){
        $credentials = ['name' => $request->name, 'password' => $request->password];
        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/client-view');
        } else {
            dd('aa');
        }
    }
}
