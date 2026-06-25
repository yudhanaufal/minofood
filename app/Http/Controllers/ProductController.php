<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction; // Tambahkan ini agar tidak error saat hapus
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar barang dan kategori.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all(); 
    
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'unit' => 'required',
            'category_id' => 'required'
        ]);

        // 2. Simpan ke database (Cukup satu kali panggil)
        Product::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
            'stock' => 0 // Stok awal barang baru selalu nol
        ]);

        return redirect()->back()->with('success', 'Barang baru berhasil ditambahkan!');
    }

    /**
     * Menghapus barang beserta riwayat transaksinya.
     */
    public function destroy(string $id)
    {
        // 1. Cari barangnya
        $product = Product::findOrFail($id);

        // 2. Hapus semua riwayat transaksi barang ini agar tidak error Foreign Key
        Transaction::where('product_id', $id)->delete();

        // 3. Hapus barang utamanya
        $product->delete();

        return redirect()->back()->with('success', 'Barang dan riwayat transaksinya berhasil dihapus!');
    }

    // Fungsi create, show, edit, update bisa dibiarkan kosong jika belum digunakan
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
}