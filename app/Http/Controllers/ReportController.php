<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Ambil semua riwayat transaksi beserta data produk dan usernya
        $transactions = Transaction::with(['product', 'user'])->latest()->get();

        // 2. Hitung total barang masuk dan keluar untuk statistik di atas
        $totalIn = Transaction::where('type', 'in')->sum('quantity');
        $totalOut = Transaction::where('type', 'out')->sum('quantity');

        // 3. Kirim data ke view reports.index
        return view('reports.index', compact('transactions', 'totalIn', 'totalOut'));
    }
}