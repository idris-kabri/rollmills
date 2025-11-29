<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use HasToastNotification;
    use WithFileUploads;
    public $name;
    public $email;
    public $mobile;

    public $profile_image;
    public $new_profile_image;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->mobile = Auth::user()->mobile;
        $this->profile_image = Auth::user()->profile_image;
    }

    public function updatedNewProfileImage()
    {
        $this->validate([
            'new_profile_image' => 'nullable|image|max:2048'
        ]);
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'mobile' => 'required|string|max:15|unique:users,mobile,' . Auth::id(),
        ]);

        try {
            DB::beginTransaction();

            $user = User::find(Auth::id());
            $user->name  = $this->name;
            $user->email = $this->email;
            $user->mobile = $this->mobile;

            if ($this->new_profile_image) {
                $path = $this->new_profile_image->store('profile_images', 'public');
                $user->profile_image = $path;

                $this->profile_image = $path;
            }

            $user->save();

            DB::commit();
            $this->toastSuccess('Profile updated successfully!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Profile Update Error: ' . $e->getMessage());
            $this->toastError('An error occurred while updating the profile.');
        }
    }

    public function render()
    {
        return view('livewire.user.profile')->layout('layouts.user.app');
    }
}
