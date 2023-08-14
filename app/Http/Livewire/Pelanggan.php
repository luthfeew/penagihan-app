<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Pelanggan as PelangganModel;
use App\Models\Paket;
use App\Models\Area;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Pelanggan extends Component
{
    use WithFileUploads, WithPagination;

    public $nama, $telepon, $tglRegister, $tglTagihan, $tglIsolir, $paket, $area, $saldo;
    public $tambahan1, $biaya1, $tambahan2, $biaya2, $diskon;
    public $ppoe, $infoModem;
    public $alamat, $foto, $oldFoto;
    public $cari = '', $listPaket, $listArea, $action, $pelangganId;

    public function mount()
    {
        $this->listPaket = Paket::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama . ' @ Rp. ' . number_format($item->tarif, 0, ',', '.'),
            ];
        })->pluck('nama', 'id')->toArray();
        $this->listArea = Area::all()->pluck('nama', 'id')->toArray();
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'components.pagination';
    }

    public function render()
    {
        return view('livewire.pelanggan', [
            'pelanggans' => PelangganModel::where('nama', 'like', '%' . $this->cari . '%')
                ->orWhere('telepon', 'like', '%' . $this->cari . '%')
                ->paginate(20),
        ])->layoutData(['title' => 'Pelanggan']);
    }

    public function resetFields()
    {
        $this->reset([
            'nama', 'telepon', 'tglRegister', 'tglTagihan', 'tglIsolir', 'paket', 'area',
            'tambahan1', 'biaya1', 'tambahan2', 'biaya2', 'diskon',
            'ppoe', 'infoModem', 'alamat', 'foto', 'oldFoto',
        ]);
        $this->resetErrorBag();
    }

    public function getData($id)
    {
        $pelanggan = PelangganModel::find($id);
        $this->pelangganId = $id;
        $this->saldo = $pelanggan->saldo->saldo;
        $this->nama = $pelanggan->nama;
        $this->telepon = $pelanggan->telepon;
        $this->tglRegister = Str::substr($pelanggan->tanggal_register, 0, 10);
        $this->tglTagihan = $pelanggan->tanggal_tagihan;
        $this->tglIsolir = $pelanggan->tanggal_isolir;
        $this->paket = $pelanggan->paket_id;
        $this->area = $pelanggan->area_id;
        $this->tambahan1 = $pelanggan->tambahan1;
        $this->biaya1 = $pelanggan->biaya1;
        $this->tambahan2 = $pelanggan->tambahan2;
        $this->biaya2 = $pelanggan->biaya2;
        $this->diskon = $pelanggan->diskon;
        $this->ppoe = $pelanggan->ppoe;
        $this->infoModem = $pelanggan->info_modem;
        $this->alamat = $pelanggan->alamat;
        $this->oldFoto = $pelanggan->foto;
    }

    public function lihat($id)
    {
        $this->resetFields();

        $this->getData($id);

        $this->action = 'lihat';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'pelanggan']);
    }

    public function tambah()
    {
        $this->resetFields();
        $this->action = 'tambah';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'pelanggan']);
    }

    public function edit($id)
    {
        $this->resetFields();

        $this->getData($id);

        $this->action = 'edit';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'pelanggan']);
    }

    public function hapus($id)
    {
        $pelanggan = PelangganModel::find($id);
        $pelanggan->delete();

        if ($pelanggan->foto) {
            Storage::disk('custom')->delete($pelanggan->foto);
        }

        $this->dispatchBrowserEvent('showToast', ['message' => 'Pelanggan berhasil dihapus.']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|string|min:3',
            'telepon' => 'required|string|max:25',
            'tglRegister' => 'nullable|date',
            'tglTagihan' => 'nullable|numeric|min:1|max:31',
            'tglIsolir' => 'nullable|numeric|min:1|max:31',
            'paket' => 'required|exists:pakets,id',
            'area' => 'required|exists:areas,id',
            'tambahan1' => 'nullable|string|required_with:biaya1',
            'biaya1' => 'nullable|numeric|min:1',
            'tambahan2' => 'nullable|string|required_with:biaya2',
            'biaya2' => 'nullable|numeric|min:1',
            'diskon' => 'nullable|numeric',
            'ppoe' => 'nullable|string',
            'infoModem' => 'nullable|string',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:1024',
        ], [
            'nama.required' => ':attribute tidak boleh kosong.',
            'nama.string' => ':attribute harus berupa string.',
            'nama.min' => ':attribute minimal 3 karakter.',
            'telepon.required' => ':attribute tidak boleh kosong.',
            'telepon.string' => ':attribute harus berupa string.',
            'telepon.max' => ':attribute maksimal 25 karakter.',
            'tglRegister.date' => ':attribute harus berupa tanggal.',
            // 'tglTagihan.required' => ':attribute tidak boleh kosong.',
            'tglTagihan.numeric' => ':attribute harus berupa angka.',
            'tglTagihan.min' => ':attribute minimal 1.',
            'tglTagihan.max' => ':attribute maksimal 31.',
            'tglIsolir.numeric' => ':attribute harus berupa angka.',
            'tglIsolir.min' => ':attribute minimal 1.',
            'tglIsolir.max' => ':attribute maksimal 31.',
            'paket.required' => ':attribute tidak boleh kosong.',
            'paket.exists' => ':attribute tidak ditemukan.',
            'area.required' => ':attribute tidak boleh kosong.',
            'area.exists' => ':attribute tidak ditemukan.',
            'tambahan1.string' => ':attribute harus berupa string.',
            'tambahan1.required_with' => ':attribute tidak boleh kosong.',
            'biaya1.numeric' => ':attribute harus berupa angka.',
            'biaya1.min' => ':attribute minimal 1.',
            'tambahan2.string' => ':attribute harus berupa string.',
            'tambahan2.required_with' => ':attribute tidak boleh kosong.',
            'biaya2.numeric' => ':attribute harus berupa angka.',
            'biaya2.min' => ':attribute minimal 1.',
            'diskon.numeric' => ':attribute harus berupa angka.',
            'foto.image' => ':attribute harus berupa gambar.',
            'foto.max' => ':attribute maksimal 1 MB.',
        ], [
            'nama' => 'Nama pelanggan',
            'telepon' => 'Telepon pelanggan',
            'tglRegister' => 'Tanggal register',
            'tglTagihan' => 'Tanggal tagihan',
            'tglIsolir' => 'Tanggal isolir',
            'paket' => 'Paket',
            'area' => 'Area',
            'tambahan1' => 'Tambahan 1',
            'biaya1' => 'Biaya 1',
            'tambahan2' => 'Tambahan 2',
            'biaya2' => 'Biaya 2',
            'diskon' => 'Diskon',
            'ppoe' => 'PPoE',
            'infoModem' => 'Info modem',
            'alamat' => 'Alamat',
            'foto' => 'Foto',
        ]);

        if ($this->action == 'tambah') {
            PelangganModel::create([
                'nama' => $this->nama,
                'telepon' => $this->telepon,
                'tanggal_register' => $this->tglRegister ?? date('Y-m-d'),
                'tanggal_tagihan' => $this->tglTagihan ?? date('d'),
                // 'tanggal_isolir' => $this->tglIsolir ?? $this->tglTagihan,
                'paket_id' => $this->paket,
                'area_id' => $this->area,
                'tambahan1' => $this->tambahan1,
                'biaya1' => $this->biaya1,
                'tambahan2' => $this->tambahan2,
                'biaya2' => $this->biaya2,
                'diskon' => $this->diskon,
                'ppoe' => $this->ppoe,
                'info_modem' => $this->infoModem,
                'alamat' => $this->alamat,
                'foto' => $this->foto ? $this->foto->store('foto', 'custom') : $this->oldFoto,
            ]);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Pelanggan berhasil ditambahkan.']);
        } else {
            PelangganModel::find($this->pelangganId)->update([
                'nama' => $this->nama,
                'telepon' => $this->telepon,
                'tanggal_register' => $this->tglRegister ?? date('Y-m-d'),
                'tanggal_tagihan' => $this->tglTagihan,
                // 'tanggal_isolir' => $this->tglIsolir ?? $this->tglTagihan,
                'paket_id' => $this->paket,
                'area_id' => $this->area,
                'tambahan1' => $this->tambahan1,
                'biaya1' => $this->biaya1,
                'tambahan2' => $this->tambahan2,
                'biaya2' => $this->biaya2,
                'diskon' => $this->diskon,
                'ppoe' => $this->ppoe,
                'info_modem' => $this->infoModem,
                'alamat' => $this->alamat,
                'foto' => $this->foto ? $this->foto->store('foto', 'custom') : $this->oldFoto,
            ]);

            if ($this->foto && $this->oldFoto) {
                Storage::disk('custom')->delete($this->oldFoto);
            }

            $this->dispatchBrowserEvent('showToast', ['message' => 'Data pelanggan berhasil diperbarui.']);
        }

        $this->dispatchBrowserEvent('closeDialog', ['id' => 'pelanggan']);
    }
}
