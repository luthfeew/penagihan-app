<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tagihan_id',
        'pelanggan_id',
        'saldo_id',
        'kode',
        'total_tagihan',
        'bayar',
        'lebih',
        'kurang',
        'jenis',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function saldo()
    {
        return $this->belongsTo(Saldo::class);
    }
}
