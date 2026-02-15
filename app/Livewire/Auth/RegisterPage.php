<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;



#[Title('Register')]

class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    //Register User

    public function save(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        //save to database
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        //login user
        Auth::login($user);

        //redirect to home page

        return redirect()->intended('/');

    }


    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
