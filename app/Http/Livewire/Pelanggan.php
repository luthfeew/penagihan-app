<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pelanggan extends Component
{
    public function render()
    {
        return view('livewire.pelanggan')->layoutData(['title' => 'Pelanggan']);
    }
}
