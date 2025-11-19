<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Account extends Component
{
    public $user;
    public $showLogoutModal = false;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.user.account')->layout('layouts.app', ['title' => 'Akun']);
    }

    public function confirmLogout()
    {
        $this->showLogoutModal = true;
    }

    public function cancelLogout()
    {
        $this->showLogoutModal = false;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }
}