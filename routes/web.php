<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailController;

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

Route::get('/', function () {
    return redirect()->route('transaksi.index');
});

//Route untuk Produk
Route::post('produk', [ProdukController::class, 'store'])->name('produk.store');
Route::put('produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::get('produk/edit/{produk}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::get('produk', [ProdukController::class, 'produk'])->name('produk.index');

//Route Transaksi
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi.index');
Route::get('transaksi/search', [TransaksiController::class, 'search'])->name('produk.search');

Route::get('detailtransaksi', [DetailController::class, 'detail'])->name('detail.index');
Route::get('detail-transaksi/{transaksi_id}/print', [DetailController::class, 'show'])->name('detail-transaksi.print');
Route::get('transaksi/{id}/print', [DetailController::class, 'show'])->name('transaksi.print');