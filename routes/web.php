<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Beranda;
use App\Http\Livewire\Transaksi;
use App\Http\Livewire\Bayar;
use App\Http\Livewire\Pengaduan;
use App\Http\Livewire\Pelanggan;
use App\Http\Livewire\Pengaturan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Beranda::class);
Route::get('/transaksi', Transaksi::class);
Route::get('/bayar', Bayar::class);
Route::get('/pengaduan', Pengaduan::class);
Route::get('/pelanggan', Pelanggan::class);
Route::get('/pengaturan', Pengaturan::class);
