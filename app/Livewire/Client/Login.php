<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $password;

    #[Layout('client')]
    public function render()
    {
        return view('livewire.client.login');
    }

    public function login(){
        // $this->validate();
        // $credentials = ['name' => $this->name, 'password' => $this->password];
        $client = Client::where('name', $this->name)->first();

        if ($client && Crypt::decrypt($client->password) === $this->password) {
            Auth::guard('client')->login($client);
            return redirect('/client-view');
        } else {
            $this->addError('login', 'Nama atau Password salah...!');
        }
        // if (Auth::guard('client')->attempt($credentials, true)) {
        //     session()->regenerate();
        //     return redirect('/client-view');
        // } else {
        //     dd('aaa');
        // }
    }

}
