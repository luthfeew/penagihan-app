<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pengaturan extends Component
{
    public function render()
    {
        return view('livewire.pengaturan')->layoutData(['title' => 'Pengaturan']);
    }
}
