<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{
    public function render()
    {
        return view('livewire.user.settings')->layout('layouts.app', ['title' => 'Settings']);
    }

    public function goToNotificationSettings()
    {
        return redirect()->route('settings.notifications');
    }

    public function goToPasswordManager()
    {
        return redirect()->route('settings.password');
    }

    public function goToDeleteAccount()
    {
        return redirect()->route('settings.delete-account');
    }
}