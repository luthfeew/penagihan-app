<?php

namespace App\Http\Livewire\Pengaturan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Area as AreaModel;
use Masmerise\Toaster\Toaster;

class Area extends Component
{
    public $nama, $areaId, $action;

    public function render()
    {
        return view('livewire.pengaturan.area', [
            'areas' => AreaModel::orderBy('nama')->get(),
        ]);
    }

    public function tambah()
    {
        $this->reset();
        $this->action = 'tambah';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'area']);
    }

    public function edit($id)
    {
        $this->reset();
        $this->areaId = $id;
        $this->nama = AreaModel::find($id)->nama;
        $this->action = 'edit';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'area']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|string|min:3|unique:areas,nama,' . $this->areaId,
        ], [
            'nama.required' => ':attribute tidak boleh kosong.',
            'nama.string' => ':attribute harus berupa string.',
            'nama.min' => ':attribute minimal 3 karakter.',
            'nama.unique' => ':attribute sudah ada.',
        ], [
            'nama' => 'Nama area',
        ]);

        if ($this->action == 'tambah') {
            AreaModel::create([
                'nama' => $this->nama,
            ]);
        } else {
            AreaModel::find($this->areaId)->update([
                'nama' => $this->nama,
            ]);
        }

        $this->dispatchBrowserEvent('closeDialog', ['id' => 'area']);
    }
}
