<?php

namespace App\Livewire;

use App\Enum\UserTypeEnum;
use App\Models\User;
use Livewire\Component;

class SignUpScreen extends Component
{
    public $fullName = '';
    public $email = '';
    public $username = '';
    public $password = '';
    public $acceptTerms = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone_number' => 'required',
        'password' => 'required|min:8',
        'acceptTerms' => 'accepted'
    ];

    public function signUp()
    {
        $data = $this->validate();

        // Perform sign up logic here
        User::create([...$data, 'password' => bcrypt($data['password']), 'type' => UserTypeEnum::USER]);


        session()->flash('message', 'Account created successfully!');
    }

    public function render()
    {
        return view('livewire.sign-up-screen');
    }
}
