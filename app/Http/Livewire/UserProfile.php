<?php

namespace App\Http\Livewire;
use App\Models\User;

use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('admin.states.create');
    }
}
