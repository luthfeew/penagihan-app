<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password;

    public function render()
    {
        return view('livewire.login')->layout('layouts.guest', ['title' => 'Login']);
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        $this->dispatchBrowserEvent('showToast', ['message' => 'Email atau password salah!']);
    }
}
