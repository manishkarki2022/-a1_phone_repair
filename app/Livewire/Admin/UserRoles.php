<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserRoles extends Component
{
    public $user;
    public $role;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->role = $user->role;
    }

    public function updateRole()
    {
        $this->validate([
            'role' => ['required', 'in:admin,staff,customer'],
        ]);

        $this->user->update(['role' => $this->role]);
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.admin.user-roles');
    }
}
