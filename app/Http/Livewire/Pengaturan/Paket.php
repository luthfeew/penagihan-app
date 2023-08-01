<?php

namespace App\Http\Livewire\Pengaturan;

use Livewire\Component;
use App\Models\Paket as PaketModel;

class Paket extends Component
{
    public $nama, $tarif, $keterangan, $paketId, $action;

    public function render()
    {
        return view('livewire.pengaturan.paket', [
            'pakets' => PaketModel::orderBy('tarif')->get(),
        ]);
    }

    public function tambah()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->action = 'tambah';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'paket']);
    }

    public function edit($id)
    {
        $this->reset();
        $this->resetErrorBag();

        $paket = PaketModel::find($id);
        $this->paketId = $id;
        $this->nama = $paket->nama;
        $this->tarif = $paket->tarif;
        $this->keterangan = $paket->keterangan;

        $this->action = 'edit';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'paket']);
    }

    public function hapus($id)
    {
        PaketModel::find($id)->forceDelete();
        $this->dispatchBrowserEvent('showToast', ['message' => 'Paket berhasil dihapus.']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|string|min:3|unique:pakets,nama,' . $this->paketId,
            'tarif' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ], [
            'nama.required' => ':attribute tidak boleh kosong.',
            'nama.string' => ':attribute harus berupa string.',
            'nama.min' => ':attribute minimal 3 karakter.',
            'nama.unique' => ':attribute sudah ada.',
            'tarif.required' => ':attribute tidak boleh kosong.',
            'tarif.numeric' => ':attribute harus berupa angka.',
            'tarif.min' => ':attribute minimal 0.',
            'keterangan.string' => ':attribute harus berupa string.',
        ], [
            'nama' => 'Nama paket',
            'tarif' => 'Tarif paket',
            'keterangan' => 'Keterangan paket',
        ]);

        if ($this->action == 'tambah') {
            PaketModel::create([
                'nama' => $this->nama,
                'tarif' => $this->tarif,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Paket berhasil ditambahkan.']);
        } else {
            PaketModel::find($this->paketId)->update([
                'nama' => $this->nama,
                'tarif' => $this->tarif,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Paket berhasil diubah.']);
        }

        $this->dispatchBrowserEvent('closeDialog', ['id' => 'paket']);
    }
}
