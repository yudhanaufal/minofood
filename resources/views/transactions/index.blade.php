<x-app-layout>
    <!-- CSS Custom untuk Tema Cafe Transaksi -->
    <style>
        .cafe-container-trx {
            background-image: linear-gradient(rgba(31, 19, 13, 0.88), rgba(31, 19, 13, 0.88)), 
                              url('https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .glass-panel-trx {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }

        .coffee-accent-bar {
            border-top: 5px solid #4B3621;
        }

        .input-coffee:focus {
            border-color: #6F4E37 !important;
            box-shadow: 0 0 0 3px rgba(111, 78, 55, 0.2) !important;
        }

        .btn-coffee-submit {
            background: linear-gradient(135deg, #6F4E37 0%, #3E2723 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-coffee-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(62, 39, 35, 0.4);
        }

        /* Badge Styles */
        .badge-in { background-color: #ecfdf5; color: #065f46; border: 1px solid #10b981; }
        .badge-out { background-color: #fef2f2; color: #991b1b; border: 1px solid #ef4444; }

        .cafe-table-header {
            background-color: #3E2723;
            color: #D7CCC8;
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-[#4B3621] rounded-lg text-white shadow-md">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
                {{ __('Transaksi Barang Masuk & Keluar') }}
            </h2>
        </div>
    </x-slot>

    <div class="cafe-container-trx py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- NOTIFIKASI -->
            @if (session('success'))
                <div class="bg-emerald-600 text-white p-4 rounded-2xl shadow-xl mb-4 flex items-center gap-3 animate-pulse">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span class="font-bold uppercase text-sm tracking-wide">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-600 text-white p-4 rounded-2xl shadow-xl mb-4 flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <span class="font-bold uppercase text-sm tracking-wide">{{ session('error') }}</span>
                </div>
            @endif

            <!-- 1. FORM INPUT TRANSAKSI (Premium Glass) -->
            <div class="glass-panel-trx p-8 sm:rounded-3xl coffee-accent-bar relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class="fas fa-mug-hot text-9xl text-amber-900"></i>
                </div>

                <div class="flex items-center gap-2 mb-8">
                    <i class="fas fa-pen-fancy text-amber-800"></i>
                    <h3 class="text-xs font-black text-amber-900 uppercase tracking-[0.3em] italic">Catat Pergerakan Stok</h3>
                </div>
                
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
                        <!-- Pilih Produk -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Pilih Barang</label>
                            <select name="product_id" class="w-full rounded-xl border-gray-200 input-coffee text-sm font-bold h-12" required>
                                <option value="">-- Cari Barang --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} (Sisa: {{ $p->stock }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipe Transaksi -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Tipe Transaksi</label>
                            <select name="type" class="w-full rounded-xl border-gray-200 input-coffee text-sm font-black h-12" required>
                                <option value="in" class="text-emerald-600 font-bold">Barang Masuk (+)</option>
                                <option value="out" class="text-red-600 font-bold">Barang Keluar (-)</option>
                            </select>
                        </div>

                        <!-- Jumlah Qty -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Jumlah Qty</label>
                            <input type="number" name="quantity" min="1" class="w-full rounded-xl border-gray-200 input-coffee h-12 font-black text-lg" placeholder="0" required>
                        </div>

                        <!-- Tanggal -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Tanggal Input</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 input-coffee h-12 text-sm" required>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="btn-coffee-submit text-white font-black py-4 px-12 rounded-2xl shadow-2xl flex items-center gap-3 uppercase tracking-widest text-xs">
                            <i class="fas fa-save"></i> Konfirmasi & Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. RIWAYAT TRANSAKSI (Tabel Menu Kopi) -->
            <div class="glass-panel-trx overflow-hidden sm:rounded-3xl border-none">
                <div class="p-6 bg-amber-50/50 border-b border-amber-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-history text-amber-800"></i>
                        <h3 class="text-xs font-black text-amber-900 uppercase tracking-widest">Riwayat Aktivitas Gudang</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="cafe-table-header">
                            <tr>
                                <th class="p-5 text-[10px] font-black uppercase tracking-widest">Waktu & Tanggal</th>
                                <th class="p-5 text-[10px] font-black uppercase tracking-widest">Item Produk</th>
                                <th class="p-5 text-[10px] font-black uppercase tracking-widest text-center">Status</th>
                                <th class="p-5 text-[10px] font-black uppercase tracking-widest text-center">Qty</th>
                                <th class="p-5 text-[10px] font-black uppercase tracking-widest">Petugas (PIC)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @forelse($transactions as $t)
                            <tr class="hover:bg-amber-50/40 transition-all group">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <i class="far fa-clock text-amber-800/30"></i>
                                        <span class="text-xs font-bold text-gray-600">{{ $t->date }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <p class="font-black text-gray-800 uppercase tracking-tight group-hover:text-amber-900 transition-colors">
                                        {{ $t->product->name }}
                                    </p>
                                    <p class="text-[9px] text-gray-400 font-bold italic">{{ $t->product->sku }}</p>
                                </td>
                                <td class="p-5 text-center">
                                    @if($t->type == 'in')
                                        <span class="badge-in px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-tighter">Masuk (+)</span>
                                    @else
                                        <span class="badge-out px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-tighter">Keluar (-)</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <span class="text-xl font-black {{ $t->type == 'in' ? 'text-emerald-600' : 'text-red-700' }}">
                                        {{ $t->quantity }}
                                    </span>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#3E2723] flex items-center justify-center text-white text-[10px] font-black shadow-md border-2 border-white">
                                            {{ substr($t->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-[11px] font-black text-gray-700 uppercase tracking-wide">{{ $t->user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-24 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i class="fas fa-clipboard-list text-6xl mb-4 text-amber-900"></i>
                                        <p class="italic text-amber-900 font-bold uppercase tracking-widest text-xs">Belum ada catatan transaksi hari ini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="bg-amber-900/5 p-4 text-center border-t border-amber-100">
                    <p class="text-[9px] font-bold text-amber-900/40 uppercase tracking-[0.4em]">Mino Food Indonesia - Coffee Quality Control</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Link FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-app-layout>