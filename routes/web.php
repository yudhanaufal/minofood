<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController; 
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Transaction;

// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Hanya bisa dibuka jika sudah login)
Route::get('/dashboard', function () {
    return view('dashboard',[

        // Menghitung total jenis barang
        'totalProduk' => Product::count(),

          // Menghitung produk yang stoknya di bawah 10 (Stok Menipis)
        'stokMenipis' => Product::where('stock', '<=', 10)->count(),

         // Menghitung transaksi yang dilakukan hari ini
        'transaksiHariIni' => Transaction::whereDate('created_at', now())->count(),
    ]);

    return view('dashboard', $data);

})->middleware(['auth', 'verified'])->name('dashboard');

// Group Route untuk User yang sudah Login
Route::middleware('auth')->group(function () {
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // ... route lainnya ...
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    
    // Route Master Barang
    Route::resource('products', ProductController::class);

    // Jalur Laporan (Hanya untuk Owner)
    Route::get('/reports', [ReportController::class, 'index'])->middleware('role:owner')->name('reports.index');

    // Route Manajemen User
    Route::resource('users', UserController::class);

    Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    });
});

// Memanggil file auth.php bawaan Breeze
require __DIR__.'/auth.php';