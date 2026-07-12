<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $errorMessage = '';

    public function authenticate()
    {
        // Attempt to log the user in using the local SQLite database
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Success! Reload the page to reveal the app layout
            return redirect()->to('/');
        }

        // Failure: Show error message
        $this->errorMessage = 'Invalid credentials. Please try again.';
        $this->password = ''; // Clear the password field for security
    }

    public function render()
    {
        return view('livewire.login');
    }
}