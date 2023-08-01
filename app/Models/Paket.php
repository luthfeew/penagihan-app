<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'tarif',
        'keterangan',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
