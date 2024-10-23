<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerLogin extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->to('/dashboard');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
    public function render()
    {
        return view('livewire.customer-login');
    }
}
