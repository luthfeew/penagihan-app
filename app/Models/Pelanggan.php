<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'telepon',
        'tanggal_register',
        'tanggal_tagihan',
        'tanggal_isolir',
        'paket_id',
        'area_id',
        'tambahan1',
        'biaya1',
        'tambahan2',
        'biaya2',
        'diskon',
        'prorata',
        'tanggal_pasang',
        'hasil_prorata',
        'ppoe',
        'info_modem',
        'alamat',
        'latitude',
        'longitude',
        'foto',
    ];

    protected static function booted(): void
    {
        // buat tagihan dan saldo otomatis ketika pelanggan baru dibuat
        static::created(function ($pelanggan) {
            Tagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'bulan' => date('Y-m-d'),
                'is_lunas' => false,
            ]);
            Saldo::create([
                'pelanggan_id' => $pelanggan->id,
                'saldo' => 10000,
            ]);
        });

        // hapus tagihan dan saldo otomatis ketika pelanggan dihapus
        static::deleted(function ($pelanggan) {
            Tagihan::where('pelanggan_id', $pelanggan->id)->delete();
            Saldo::where('pelanggan_id', $pelanggan->id)->delete();
        });
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function saldo()
    {
        return $this->hasOne(Saldo::class);
    }
}
