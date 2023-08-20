<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Perawatan as PerawatanModel;
use Illuminate\Support\Str;

class Perawatan extends Component
{
    public $nama, $biaya, $waktu, $perawatanId, $action;

    public function render()
    {
        return view('livewire.perawatan', [
            'perawatans' => PerawatanModel::withTrashed()->orderBy('created_at', 'desc')->get(),
        ])->layoutData(['title' => 'Perawatan']);
    }

    public function tambah()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->action = 'tambah';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'perawatan']);
    }

    public function edit($id)
    {
        $this->reset();
        $this->resetErrorBag();

        $this->perawatanId = $id;
        $perawatan = PerawatanModel::withTrashed()->find($id);
        $this->nama = $perawatan->nama;
        $this->biaya = $perawatan->biaya;
        $this->waktu = Str::substr($perawatan->waktu, 0, 10);

        $this->action = 'edit';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'perawatan']);
    }

    public function hapus($id)
    {
        PerawatanModel::find($id)->forceDelete();
        $this->dispatchBrowserEvent('showToast', ['message' => 'Biaya berhasil dihapus.']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|string|min:3',
            'biaya' => 'required|numeric|min:0',
            'waktu' => 'nullable|date',
        ], [
            'nama.required' => ':attribute tidak boleh kosong.',
            'nama.string' => ':attribute harus berupa string.',
            'nama.min' => ':attribute minimal 3 karakter.',
            'biaya.required' => ':attribute tidak boleh kosong.',
            'biaya.numeric' => ':attribute harus berupa angka.',
            'biaya.min' => ':attribute minimal 0.',
            'waktu.date' => ':attribute harus berupa tanggal.',
        ], [
            'nama' => 'Keterangan',
            'biaya' => 'Biaya',
            'waktu' => 'Waktu',
        ]);

        if ($this->action == 'tambah') {
            PerawatanModel::create([
                'nama' => $this->nama,
                'biaya' => $this->biaya,
                'waktu' => $this->waktu ?? date('Y-m-d'),
            ]);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Biaya berhasil ditambahkan.']);
        } else {
            PerawatanModel::find($this->perawatanId)->update([
                'nama' => $this->nama,
                'biaya' => $this->biaya,
                'waktu' => $this->waktu ?? date('Y-m-d')
            ]);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Biaya berhasil diubah.']);
        }

        $this->dispatchBrowserEvent('closeDialog', ['id' => 'perawatan']);
    }
}
