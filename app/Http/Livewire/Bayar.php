<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tagihan;

class Bayar extends Component
{
    public $cari, $action;

    public function render()
    {
        $data = Tagihan::leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.*')
            ->where('pelanggans.nama', 'like', '%' . $this->cari . '%')
            ->paginate(20);
        $sorted = $data->getCollection()->sortBy('pelanggan.tanggal_tagihan')->values();
        $result = $data->setCollection($sorted);

        return view('livewire.bayar', [
            'tagihans' => $result
        ])->layoutData(['title' => 'Bayar']);
    }
}
