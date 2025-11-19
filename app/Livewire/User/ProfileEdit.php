<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $name;
    public $phone;
    public $gender;
    public $profile_photo;
    public $existing_photo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female',
        'profile_photo' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->gender = $user->gender;
        $this->existing_photo = $user->profile_photo;
    }

    public function render()
    {
        return view('livewire.user.profile-edit')->layout('layouts.app', ['title' => 'Edit Profile']);
    }

    public function updateProfile()
    {
        $this->validate();

        try {
            $user = Auth::user();

            $data = [
                'name' => $this->name,
                'phone' => $this->phone,
                'gender' => $this->gender,
            ];

            // Handle profile photo upload
            if ($this->profile_photo) {
                // Delete old photo if exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Store new photo
                $data['profile_photo'] = $this->profile_photo->store('profile-photos', 'public');
            }

            $user->update($data);

            $this->dispatch('notify', [
                'message' => '✅ Profile berhasil diperbarui',
                'type' => 'success'
            ]);

            return redirect()->route('account');

        } catch (\Exception $e) {
            \Log::error('Profile update failed', ['error' => $e->getMessage()]);
            
            $this->dispatch('notify', [
                'message' => '❌ Gagal memperbarui profile',
                'type' => 'error'
            ]);
        }
    }
}