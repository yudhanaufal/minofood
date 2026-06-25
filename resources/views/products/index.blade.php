<x-app-layout>
    <!-- CSS Custom untuk Tema Cafe -->
    <style>
        .cafe-container {
            background-image: linear-gradient(rgba(44, 24, 16, 0.8), rgba(44, 24, 16, 0.8)), 
                              url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .coffee-header {
            border-left: 6px solid #6F4E37;
        }

        .input-cafe:focus {
            border-color: #6F4E37 !important;
            ring-color: #6F4E37 !important;
        }

        .btn-coffee {
            background: linear-gradient(135deg, #6F4E37 0%, #4B3621 100%);
            transition: all 0.3s ease;
        }

        .btn-coffee:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 78, 55, 0.4);
        }

        /* Styling Tabel ala Menu Cafe */
        .cafe-table thead {
            background-color: #3E2723;
            color: #D7CCC8;
        }
    </style>

    <!-- HEADER SLANT (Opsional, menyesuaikan dashboard sebelumnya) -->
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-3xl">☕</span>
            <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
                {{ __('Master Data Barang - CV. Mino Food Indonesia') }}
            </h2>
        </div>
    </x-slot>

    <div class="cafe-container py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- ALERTS (Notifikasi) -->
            @if (session('success'))
                <div class="bg-emerald-600 text-white p-4 rounded-2xl shadow-lg mb-4 flex items-center gap-3 animate-bounce">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-8 border-red-500 text-red-700 p-5 rounded-2xl shadow-md mb-4">
                    <p class="font-black uppercase text-xs mb-2">Terjadi Kesalahan:</p>
                    <ul class="text-sm italic">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. FORM TAMBAH BARANG (Premium Glass Panel) -->
            <div class="glass-panel p-8 sm:rounded-3xl coffee-header">
                <div class="flex items-center gap-2 mb-6">
                    <i class="fas fa-plus-circle text-amber-800 text-xl"></i>
                    <h3 class="text-sm font-black text-amber-900 uppercase tracking-widest italic">Inventory Baru</h3>
                </div>
                
                <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-5">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Kode SKU</label>
                        <input type="text" name="sku" placeholder="Contoh: MNO-01" class="w-full rounded-xl border-gray-200 input-cafe font-mono" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Nama Produk</label>
                        <input type="text" name="name" placeholder="Biji Kopi Arabica" class="w-full rounded-xl border-gray-200 input-cafe" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Unit Satuan</label>
                        <input type="text" name="unit" placeholder="KG / PCS" class="w-full rounded-xl border-gray-200 input-cafe" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Kategori</label>
                        <select name="category_id" class="w-full rounded-xl border-gray-200 input-cafe" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full btn-coffee text-white font-black py-3 rounded-xl uppercase shadow-xl flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. TABEL DAFTAR BARANG (Menu Style) -->
            <div class="glass-panel overflow-hidden sm:rounded-3xl border-none">
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left cafe-table">
                        <thead>
                            <tr>
                                <th class="p-5 text-[11px] font-black uppercase tracking-widest">SKU Produk</th>
                                <th class="p-5 text-[11px] font-black uppercase tracking-widest">Deskripsi Barang</th>
                                <th class="p-5 text-[11px] font-black uppercase tracking-widest text-center">Stok Gudang</th>
                                <th class="p-5 text-[11px] font-black uppercase tracking-widest">Satuan</th>
                                <th class="p-5 text-[11px] font-black uppercase tracking-widest text-center">Kontrol</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-amber-50/50 transition-all group">
                                    <td class="p-5">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg font-mono text-xs font-bold border border-blue-200">
                                            {{ $product->sku }}
                                        </span>
                                    </td>
                                    <td class="p-5">
                                        <p class="font-black text-gray-800 group-hover:text-amber-900 transition-colors">{{ $product->name }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold"></p>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="inline-block min-w-[50px] {{ $product->stock < 10 ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-700' }} p-2 rounded-xl font-black text-xl shadow-inner">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="p-5">
                                        <span class="text-xs font-black text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $product->unit }}</span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Konfirmasi: Hapus data barang ini?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="group/btn relative bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white p-2 rounded-xl transition-all duration-300">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-20 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fas fa-box-open text-6xl mb-4 text-amber-900"></i>
                                            <p class="italic text-amber-900 font-bold uppercase tracking-widest">Gudang Masih Kosong</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Footer Tabel ala Menu Cafe -->
                <div class="bg-amber-900/10 p-4 text-center">
                    <p class="text-[10px] font-bold text-amber-900/50 uppercase tracking-widest">© Mino Food Indonesia - Inventory System v2.0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Link FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-app-layout>