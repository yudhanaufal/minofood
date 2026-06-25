<x-app-layout>
    <style>
        /* 1. BACKGROUND UTAMA DASHBOARD */
        body {
            background: linear-gradient(rgba(245, 247, 250, 0.85), rgba(245, 247, 250, 0.85)), 
                        url("{{ asset('images/bg-cafe.jpg') }}") no-repeat center center fixed !important;
            background-size: cover !important;
        }

        /* 2. EFEK GLASSMORPHISM PADA KOTAK (CARD) */
        .qi-glass-card {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            border-radius: 12px !important;
            transition: transform 0.2s ease;
        }
        
        .qi-glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .qi-header-slant {
            clip-path: polygon(0 0, 100% 0, 92% 100%, 0% 100%);
            background: linear-gradient(135deg, #54b1cd, #3e9cb9);
        }

        .qi-card-header {
            background-color: rgba(249, 250, 251, 0.5);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            padding: 10px 15px;
            border-radius: 12px 12px 0 0;
        }

        .qi-card-title {
            color: #1e40af; /* Biru lebih gelap agar kontras */
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Menghapus background default dari layout breeze */
        .py-6, .min-h-screen {
            background: transparent !important;
        }
    </style>

    <!-- HEADER CUSTOM -->
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between -m-6 bg-[#3e9cb9]/90 backdrop-blur-md shadow-lg border-b border-white/20">
            <div class="qi-header-slant px-12 py-5 pr-24 text-white shadow-xl">
                <h2 class="font-black text-2xl italic tracking-tighter drop-shadow-md">
                    MINO FOOD <span class="text-xs font-normal not-italic opacity-90 block md:inline md:ml-2">| Dashboard Gudang</span>
                </h2>
            </div>
            <div class="flex items-center gap-6 px-8 py-3 text-white">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="text-[10px] uppercase font-bold opacity-80 tracking-widest">Sistem Informasi Terintegrasi</p>
                    <p class="text-base font-black">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-white/20 flex items-center justify-center border border-white/40 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-12 gap-6">
                
                <!-- BARIS 1 KIRI: GRAFIK STOK -->
                <div class="col-span-12 lg:col-span-8 qi-glass-card shadow-lg overflow-hidden">
                    <div class="qi-card-header flex justify-between items-center">
                        <h3 class="qi-card-title flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            Grafik Pergerakan Stok (Real-time)
                        </h3>
                        <span class="text-[10px] text-gray-500 font-bold bg-gray-200/50 px-2 py-1 rounded">TAHUN {{ now()->format('Y') }}</span>
                    </div>
                    <div class="p-6" style="height: 320px;">
                        <canvas id="stockLineChart"></canvas>
                    </div>
                </div>

                <!-- BARIS 1 KANAN: RINGKASAN DATA -->
                <div class="col-span-12 lg:col-span-4 qi-glass-card shadow-lg overflow-hidden">
                    <div class="qi-card-header">
                        <h3 class="qi-card-title italic">Detail Ringkasan Gudang</h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-xs text-left border-collapse">
                            <tbody class="divide-y divide-gray-200/50 italic text-gray-700">
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="p-4 bg-white/30 font-semibold w-1/2">Nama Pengguna</td>
                                    <td class="p-4 uppercase font-black text-gray-900">{{ Auth::user()->name }}</td>
                                </tr>
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="p-4 bg-white/30 font-semibold">Jabatan Akun</td>
                                    <td class="p-4 uppercase text-blue-700 font-black flex items-center gap-2">
                                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                        {{ Auth::user()->role }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="p-4 bg-white/30 font-semibold text-gray-600">Total Master Barang</td>
                                    <td class="p-4 font-black text-xl text-gray-800">{{ $totalProduk ?? 0 }} <span class="text-[10px] font-normal opacity-60 uppercase">Units</span></td>
                                </tr>
                                <tr class="hover:bg-red-50/30 transition">
                                    <td class="p-4 bg-red-50/20 font-semibold text-red-600">Peringatan Stok Menipis</td>
                                    <td class="p-4 font-black text-xl text-red-600">{{ $stokMenipis ?? 0 }} <span class="text-[10px] font-normal opacity-60 uppercase">Items</span></td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="p-4 bg-white/30 font-semibold text-emerald-700">Aktivitas Hari Ini</td>
                                    <td class="p-4 font-black text-xl text-emerald-600 tracking-tighter">{{ $transaksiHariIni ?? 0 }} <span class="text-[10px] font-normal opacity-60 uppercase">Log</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BARIS 2 KIRI: STATUS PERSETUJUAN -->
                <div class="col-span-12 lg:col-span-4 qi-glass-card shadow-lg overflow-hidden">
                    <div class="qi-card-header">
                        <h3 class="qi-card-title">Status Persetujuan (Order)</h3>
                    </div>
                    <div class="p-10 flex flex-col items-center justify-center text-gray-400">
                        <div class="relative">
                            <svg class="w-16 h-16 mb-4 opacity-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                            <span class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-gray-300 ring-4 ring-white/50"></span>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Antrian Kosong</p>
                    </div>
                </div>

                <!-- BARIS 2 TENGAH: KOMPOSISI -->
                <div class="col-span-12 lg:col-span-4 qi-glass-card shadow-lg overflow-hidden">
                    <div class="qi-card-header">
                        <h3 class="qi-card-title text-center">Komposisi Inventori</h3>
                    </div>
                    <div class="p-6 flex justify-center" style="height: 240px;">
                        <canvas id="stockPieChart"></canvas>
                    </div>
                </div>

                <!-- BARIS 2 KANAN: AKSES CEPAT -->
                <div class="col-span-12 lg:col-span-4 qi-glass-card shadow-lg overflow-hidden">
                    <div class="qi-card-header">
                        <h3 class="qi-card-title">Technical Execution</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        
                        <!-- Transaksi -->
                        <a href="{{ route('transactions.index') }}" class="flex justify-between items-center group bg-white/40 p-3 rounded-xl border border-white/50 hover:bg-emerald-500/10 transition duration-300">
                            <div>
                                <p class="text-[9px] uppercase font-black text-emerald-700 tracking-wider">Transaksi Stok</p>
                                <p class="text-2xl font-black text-emerald-600">INPUT <span class="text-xs font-normal opacity-50 ml-1">→</span></p>
                            </div>
                            <div class="h-10 w-10 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 group-hover:scale-110 transition">
                                <i class="fas fa-plus-circle text-xl"></i>
                            </div>
                        </a>

                        @if(Auth::user()->role == 'owner' || Auth::user()->role == 'admin')
                        <a href="{{ route('products.index') }}" class="flex justify-between items-center group bg-white/40 p-3 rounded-xl border border-white/50 hover:bg-blue-500/10 transition duration-300">
                            <div>
                                <p class="text-[9px] uppercase font-black text-blue-700 tracking-wider">Kelola Master</p>
                                <p class="text-2xl font-black text-blue-600">UPDATE <span class="text-xs font-normal opacity-50 ml-1">→</span></p>
                            </div>
                            <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 group-hover:scale-110 transition">
                                <i class="fas fa-sync text-xl"></i>
                            </div>
                        </a>
                        @endif

                        @if(Auth::user()->role == 'owner')
                        <a href="{{ route('reports.index') }}" class="flex justify-between items-center group bg-white/40 p-3 rounded-xl border border-white/50 hover:bg-amber-500/10 transition duration-300">
                            <div>
                                <p class="text-[9px] uppercase font-black text-amber-700 tracking-wider">Laporan Bulanan</p>
                                <p class="text-2xl font-black text-amber-500">REKAP <span class="text-xs font-normal opacity-50 ml-1">→</span></p>
                            </div>
                            <div class="h-10 w-10 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600 group-hover:scale-110 transition">
                                <i class="fas fa-file-signature text-xl"></i>
                            </div>
                        </a>
                        @endif
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts untuk Grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set Default Font untuk Chart.js agar senada dengan UI
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#4b5563';

        // 1. Line Chart
        const ctxLine = document.getElementById('stockLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Pergerakan Barang',
                    data: [1200, 1500, 1100, 1800, 2000, 1400],
                    borderColor: '#3e9cb9',
                    backgroundColor: 'rgba(62, 156, 185, 0.2)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: false, 
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        ticks: { font: { size: 10, weight: 'bold' } }
                    }, 
                    x: { 
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' } }
                    } 
                }
            }
        });

        // 2. Pie Chart
        const ctxPie = document.getElementById('stockPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut', /* Diubah ke doughnut agar lebih modern */
            data: {
                labels: ['Stok Aman', 'Stok Menipis'],
                datasets: [{
                    data: [80, 20],
                    backgroundColor: ['#58b284', '#e1726a'],
                    hoverOffset: 10,
                    borderWidth: 5,
                    borderColor: 'rgba(255,255,255,0.5)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', /* Melubangi tengah pie chart */
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { boxWidth: 12, padding: 20, font: { size: 11, weight: 'bold' } } 
                    } 
                }
            }
        });
    </script>
</x-app-layout>