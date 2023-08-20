<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username, $password;

    public function render()
    {
        return view('livewire.login')->layout('layouts.guest', ['title' => 'Login']);
    }

    public function authenticate()
    {
        $credentials = $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        $this->dispatchBrowserEvent('showToast', ['message' => 'Username atau password salah!']);
    }
}
