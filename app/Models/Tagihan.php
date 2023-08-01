<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tagihan',
        'tambahan1',
        'biaya1',
        'tambahan2',
        'biaya2',
        'diskon',
        'total_tagihan',
        'is_lunas',
    ];

    // protected static function booted(): void
    // {
    //     // hitung total tagihan ketika tagihan baru dibuat
    //     static::created(function ($tagihan) {
    //         $tagihan->total_tagihan = $tagihan->tagihan + $tagihan->biaya1 + $tagihan->biaya2 - $tagihan->diskon;
    //         $tagihan->save();
    //     });
    // }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
