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

    protected $casts = [
        'bulan' => 'date',
        'tagihan' => 'integer',
        'biaya1' => 'integer',
        'biaya2' => 'integer',
        'diskon' => 'integer',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
