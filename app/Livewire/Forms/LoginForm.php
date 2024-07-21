<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    //
    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $password;

    public function login(){
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            // $this->dispatch('user_logged_in');
            return redirect()->intended();
        } else {
            $this->addError('credentials', 'Email atau Password anda salah');
        }
    }


}
