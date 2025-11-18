<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Set judul halaman
        $title = 'Dashboard';

        return view('livewire.admin.dashboard')
                    ->layout('layouts.admin', ['title' => $title]); // <-- PENTING!
    }
}