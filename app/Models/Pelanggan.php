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
        // buat tagihan otomatis ketika pelanggan baru dibuat
        static::created(function ($pelanggan) {
            Tagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'bulan' => date('Y-m-d'),
                'tagihan' => $pelanggan->paket->tarif,
                'tambahan1' => $pelanggan->tambahan1,
                'biaya1' => $pelanggan->biaya1,
                'tambahan2' => $pelanggan->tambahan2,
                'biaya2' => $pelanggan->biaya2,
                'diskon' => $pelanggan->diskon,
                'is_lunas' => false,
            ]);
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
}
