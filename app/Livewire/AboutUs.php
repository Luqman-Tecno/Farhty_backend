<?php

namespace App\Livewire;

use Livewire\Component;
use Mail;

class AboutUs extends Component
{
    public $owner_name;
    public $hall_name;
    public $email;
    public $phone;
    public $location;
    public $capacity;
    public $description;
    public $services;

    protected $rules = [
        'owner_name' => 'required|min:3',
        'hall_name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'location' => 'required',
        'capacity' => 'required|numeric|min:1',
        'description' => 'required|min:50',
        'services' => 'required',
    ];

    public function sendRequest()
    {
        $validatedData = $this->validate();

        Mail::to('your-admin-email@example.com')->send(new \App\Mail\HallRequestMail($validatedData));

        session()->flash('message', 'تم إرسال طلبك بنجاح! سنراجع التفاصيل ونتواصل معك قريباً.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.about-us')->layout('layouts.app');
    }
}
