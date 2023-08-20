<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Beranda;
use App\Http\Livewire\Transaksi;
use App\Http\Livewire\Bayar;
use App\Http\Livewire\Pengaduan;
use App\Http\Livewire\Pelanggan;
use App\Http\Livewire\Pengaturan;
use App\Http\Livewire\Nota;
use App\Http\Livewire\Login;
use App\Http\Livewire\Perawatan;
use Illuminate\Support\Facades\Auth;

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

Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
Route::get('/nota/{id}', Nota::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/', Beranda::class);
    Route::get('/transaksi', Transaksi::class);
    Route::get('/bayar', Bayar::class);
    Route::get('/pengaduan', Pengaduan::class);
    Route::get('/pelanggan', Pelanggan::class);
    Route::get('/pengaturan', Pengaturan::class);
    Route::get('/perawatan', Perawatan::class);
});
