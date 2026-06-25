<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman transaksi stok.
     */
    public function index()
    {
        // Ambil semua produk untuk pilihan dropdown
        $products = Product::all();
        
        // Ambil riwayat transaksi beserta data produk dan usernya
        $transactions = Transaction::with(['product', 'user'])->latest()->get();
        
        return view('transactions.index', compact('products', 'transactions'));
    }

    /**
     * Menyimpan transaksi barang masuk/keluar dan mengupdate stok.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // 2. Ambil data produk yang dipilih
        $product = Product::findOrFail($request->product_id);

        // 3. Logika Update Stok (Matematika Gudang)
        if ($request->type == 'in') {
            // Jika Masuk: Stok bertambah
            $product->increment('stock', $request->quantity);
        } else {
            // Jika Keluar: Cek dulu apakah stok cukup
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Gagal! Stok barang tidak mencukupi untuk pengeluaran ini.');
            }
            // Jika cukup: Stok berkurang
            $product->decrement('stock', $request->quantity);
        }

        // 4. Simpan riwayat transaksi ke database
        Transaction::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(), // Mencatat siapa yang input
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'date'       => $request->date,
        ]);

        return redirect()->back()->with('success', 'Transaksi stok berhasil disimpan!');
    }
}