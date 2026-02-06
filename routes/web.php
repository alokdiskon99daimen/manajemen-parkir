<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\TipeKendaraanController;
use App\Http\Controllers\DataKendaraanController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipTierController;
use App\Http\Controllers\DatabaseBackupController;

use App\Http\Controllers\TrackAreaParkirController;

use App\Http\Controllers\TransaksiController;


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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('tarif', TarifController::class);
        Route::resource('area-parkir', AreaParkirController::class);
        Route::resource('tipe-kendaraan', TipeKendaraanController::class);
        Route::resource('data-kendaraan', DataKendaraanController::class);
        Route::resource('membership', MembershipController::class);
        Route::resource('membership-tier', MembershipTierController::class);
        Route::get('/ajax/kendaraan', [MembershipController::class, 'searchKendaraan'])->name('ajax.kendaraan');

        Route::middleware(['auth'])->group(function () {
            Route::get('/database', [DatabaseBackupController::class, 'index'])
                ->name('database.index');

            Route::get('/database/export', [DatabaseBackupController::class, 'exportSql'])
                ->name('database.export.sql');

            Route::post('/database/import', [DatabaseBackupController::class, 'import'])
                ->name('database.import');
        });
    });

    Route::get('/track-area-parkir', [TrackAreaParkirController::class, 'index'])->name('track-area-parkir');

    Route::middleware(['auth', RoleMiddleware::class . ':Petugas Parkir'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi/masuk', [TransaksiController::class, 'masuk'])->name('transaksi.masuk');
        Route::get('/transaksi/tiket-masuk/{id}', [TransaksiController::class, 'tiketMasuk'])->name('transaksi.tiket-masuk');
        Route::post('/transaksi/keluar', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
        Route::get('/transaksi/tiket-keluar/{id}', [TransaksiController::class, 'tiketKeluar'])->name('transaksi.tiket-keluar');
        Route::get('/kendaraan/search', [DataKendaraanController::class, 'search']);
        Route::get('/area/by-tipe/{id}', [TransaksiController::class, 'getAreaByTipe']);
        Route::get('/transaksi/aktif', [TransaksiController::class, 'aktif'])->name('transaksi.aktif');
        Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
        Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    });
});

require __DIR__.'/auth.php';
