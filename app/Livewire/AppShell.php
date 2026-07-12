<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AppShell extends Component
{
    public $currentTab = 'verify'; // Default tab

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.app-shell');
    }
}