<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pengaduan extends Component
{
    public function render()
    {
        return view('livewire.pengaduan')->layoutData(['title' => 'Pengaduan']);
    }
}
