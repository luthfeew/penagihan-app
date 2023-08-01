<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Bayar extends Component
{
    public function render()
    {
        return view('livewire.bayar')->layoutData(['title' => 'Bayar']);
    }
}
