<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordManager extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $showCurrentPassword = false;
    public $showNewPassword = false;
    public $showConfirmPassword = false;

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    protected $messages = [
        'current_password.required' => 'Password saat ini harus diisi',
        'new_password.required' => 'Password baru harus diisi',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        'new_password.min' => 'Password minimal 8 karakter',
    ];

    public function render()
    {
        return view('livewire.user.password-manager')->layout('layouts.app', ['title' => 'Password Manager']);
    }

    public function updatePassword()
    {
        $this->validate();

        try {
            $user = Auth::user();

            // Check if current password is correct
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Password saat ini salah');
                return;
            }

            // Check if new password is same as current
            if (Hash::check($this->new_password, $user->password)) {
                $this->addError('new_password', 'Password baru tidak boleh sama dengan password lama');
                return;
            }

            // Update password
            $user->update([
                'password' => Hash::make($this->new_password)
            ]);

            // Reset form
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

            $this->dispatch('notify', [
                'message' => '✅ Password berhasil diubah',
                'type' => 'success'
            ]);

            return redirect()->route('settings');

        } catch (\Exception $e) {
            \Log::error('Password update failed', ['error' => $e->getMessage()]);
            
            $this->dispatch('notify', [
                'message' => '❌ Gagal mengubah password',
                'type' => 'error'
            ]);
        }
    }

    public function toggleCurrentPassword()
    {
        $this->showCurrentPassword = !$this->showCurrentPassword;
    }

    public function toggleNewPassword()
    {
        $this->showNewPassword = !$this->showNewPassword;
    }

    public function toggleConfirmPassword()
    {
        $this->showConfirmPassword = !$this->showConfirmPassword;
    }
}