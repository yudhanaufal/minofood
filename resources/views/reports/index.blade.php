<x-app-layout>
    <style>
        /* 1. FORCE BACKGROUND CAFE */
        body {
            /* Overlay dibuat sedikit lebih transparan (0.8) agar gambar cafe lebih terlihat */
            background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), 
                        url("{{ asset('images/bg-cafe.jpg') }}") no-repeat center center fixed !important;
            background-size: cover !important;
        }

        /* Menghilangkan warna latar belakang bawaan sistem yang menutupi gambar */
        .min-h-screen, .bg-gray-100, .bg-gray-50, .py-12 {
            background-color: transparent !important;
        }

        /* 2. EFEK GLASSMORPHISM (KOTAK TRANSPARAN) */
        .glass-card {
            background: rgba(255, 255, 255, 0.75) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            border-radius: 1.5rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        }

        /* Styling Tabel agar lebih bersih di atas background cafe */
        table thead tr {
            background-color: rgba(243, 244, 246, 0.6) !important;
        }

        /* 3. CSS KHUSUS PRINT PDF (BERSIH & PROFESIONAL) */
        @media print {
            nav, .no-print, button, header, .font-bold.text-2xl {
                display: none !important;
            }

            body {
                background: white !important;
                margin: 0;
                padding: 20px;
            }

            .max-w-7xl {
                max-width: 100% !important;
                width: 100% !important;
            }

            .glass-card {
                background: white !important;
                border: 1px solid #eee !important;
                box-shadow: none !important;
                backdrop-filter: none !important;
                padding: 0 !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                border: 1px solid #ddd !important;
                padding: 10px !important;
                font-size: 12px !important;
            }
            
            .print-only-header {
                display: block !important;
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }
        }

        .print-only-header {
            display: none;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
            <span class="mr-3">📊</span> {{ __('Laporan Pergerakan Stok - CV. Mino Food Indonesia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KOP SURAT (Hanya muncul saat Print PDF) -->
            <div class="print-only-header">
                <h1 style="font-size: 26px; font-weight: 900;">CV. MINO FOOD INDONESIA</h1>
                <p style="font-size: 14px; color: #555;">Laporan Rekapitulasi Stok Gudang Berbasis Sistem</p>
                <p style="font-size: 12px;">Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-8 glass-card border-l-8 border-green-500 transition hover:scale-[1.01]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Barang Masuk</p>
                    <h4 class="text-4xl font-black text-green-600 tracking-tighter">+ {{ $totalIn }} <span class="text-sm font-normal text-gray-400 uppercase italic">Items</span></h4>
                </div>
                <div class="p-8 glass-card border-l-8 border-red-500 transition hover:scale-[1.01]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Barang Keluar</p>
                    <h4 class="text-4xl font-black text-red-600 tracking-tighter">- {{ $totalOut }} <span class="text-sm font-normal text-gray-400 uppercase italic">Items</span></h4>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="glass-card overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8 border-b border-gray-200/50 pb-4 no-print">
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest italic">Detail Transaksi Barang</h3>
                        <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-lg hover:bg-black transition flex items-center gap-2 active:scale-95">
                            <span>🖨️</span> CETAK LAPORAN (PDF)
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto rounded-xl">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-[10px]">Waktu & Staff</th>
                                    <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-[10px]">Barang / SKU</th>
                                    <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-[10px] text-center">Tipe</th>
                                    <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-[10px] text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transactions as $t)
                                <tr class="hover:bg-white/40 transition">
                                    <td class="p-4 text-sm text-gray-600">
                                        <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y H:i') }}</div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase italic">Staff: {{ $t->user->name ?? 'System' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800">{{ $t->product->name }}</div>
                                        <div class="text-[10px] text-blue-500 font-black"># {{ $t->product->sku }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($t->type == 'in')
                                            <span class="px-3 py-1 rounded-lg text-[9px] font-black bg-green-100 text-green-700 border border-green-200 uppercase">Masuk (+)</span>
                                        @else
                                            <span class="px-3 py-1 rounded-lg text-[9px] font-black bg-red-100 text-red-700 border border-red-200 uppercase">Keluar (-)</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-black text-xl text-gray-800">
                                        {{ number_format($t->quantity) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-400 italic uppercase tracking-widest text-xs font-bold">Data transaksi belum tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Tanda Tangan (Hanya muncul saat Print PDF) -->
                    <div class="print-only-header" style="margin-top: 60px; display: flex; justify-content: flex-end;">
                        <div style="text-align: center; width: 250px;">
                            <p>Mengetahui,</p>
                            <p style="font-weight: bold; margin-top: 5px;">Owner</p>
                            <br><br><br><br>
                            <p><strong>( ______________________ )</strong></p>
                            <p style="font-size: 10px; color: #888;">ID: {{ Auth::user()->id ?? '---' }} / REF: {{ date('YmdHis') }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>