<x-app-layout>
    <!-- CSS Khusus Tema Cafe Manajemen User -->
    <style>
        .cafe-user-bg {
            background-image: linear-gradient(rgba(26, 15, 10, 0.85), rgba(26, 15, 10, 0.85)), 
                              url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2047&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .glass-user-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .espresso-header {
            border-left: 6px solid #4B3621;
        }

        .btn-espresso {
            background: linear-gradient(135deg, #4B3621 0%, #2C1810 100%);
            transition: all 0.3s ease;
        }

        .btn-espresso:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(44, 24, 16, 0.4);
        }

        /* Badge Role Styles */
        .role-owner { background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
        .role-admin { background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .role-user { background-color: #f3f4f6; color: #374151; border: 1px solid #9ca3af; }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-[#2C1810] rounded-lg text-white shadow-md">
                <i class="fas fa-users-cog"></i>
            </div>
            <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
                {{ __('Manajemen User & Karyawan - Mino Food') }}
            </h2>
        </div>
    </x-slot>

    <div class="cafe-user-bg py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- NOTIFIKASI -->
            @if (session('success'))
                <div class="bg-emerald-600 text-white p-4 rounded-2xl shadow-xl mb-4 flex items-center gap-3">
                    <i class="fas fa-user-plus text-xl text-emerald-200"></i>
                    <span class="font-bold uppercase text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 1. FORM DAFTARKAN KARYAWAN (Glass Card) -->
            <div class="glass-user-panel p-8 sm:rounded-3xl espresso-header relative overflow-hidden">
                <div class="absolute -top-10 -right-10 opacity-5">
                    <i class="fas fa-id-card text-[200px] text-amber-900"></i>
                </div>

                <div class="flex items-center gap-2 mb-8">
                    <i class="fas fa-user-plus text-amber-800"></i>
                    <h3 class="text-xs font-black text-amber-900 uppercase tracking-[0.3em] italic">Daftarkan Karyawan Baru</h3>
                </div>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Nama Staff" class="w-full rounded-xl border-gray-200 focus:ring-[#4B3621] focus:border-[#4B3621] h-12 text-sm" required>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Alamat Email</label>
                            <input type="email" name="email" placeholder="email@minofood.com" class="w-full rounded-xl border-gray-200 focus:ring-[#4B3621] focus:border-[#4B3621] h-12 text-sm" required>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Password</label>
                            <input type="password" name="password" placeholder="Min 8 karakter" class="w-full rounded-xl border-gray-200 focus:ring-[#4B3621] focus:border-[#4B3621] h-12 text-sm" required>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Role / Jabatan</label>
                            <select name="role" class="w-full rounded-xl border-gray-200 focus:ring-[#4B3621] focus:border-[#4B3621] h-12 text-sm font-bold" required>
                                <option value="user">Staff User</option>
                                <option value="admin">Administrator</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="btn-espresso text-white font-black py-4 px-10 rounded-2xl shadow-xl flex items-center gap-3 uppercase tracking-widest text-xs">
                            <i class="fas fa-key"></i> Simpan & Beri Akses
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. DAFTAR USER AKTIF (Table Menu Style) -->
            <div class="glass-user-panel overflow-hidden sm:rounded-3xl border-none">
                <div class="p-6 bg-amber-50/50 border-b border-amber-100">
                    <h3 class="text-xs font-black text-amber-900 uppercase tracking-widest">Daftar User & Akses Aktif</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#2C1810] text-[#D7CCC8]">
                            <tr>
                                <th class="p-5 text-[10px] uppercase font-bold tracking-widest">Nama Staff</th>
                                <th class="p-5 text-[10px] uppercase font-bold tracking-widest">Kontak Email</th>
                                <th class="p-5 text-[10px] uppercase font-bold tracking-widest text-center">Otoritas</th>
                                <th class="p-5 text-[10px] uppercase font-bold tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100 bg-white/50">
                            @foreach($users as $user)
                            <tr class="hover:bg-amber-50/60 transition-all group">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <!-- Avatar Lingkaran Inisial -->
                                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 font-black border-2 border-white shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-black text-gray-800 group-hover:text-amber-900 tracking-tight">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <span class="text-xs font-medium text-gray-500 italic">{{ $user->email }}</span>
                                </td>
                                <td class="p-5 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-tighter shadow-sm
                                        {{ $user->role == 'owner' ? 'role-owner' : ($user->role == 'admin' ? 'role-admin' : 'role-user') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="p-5 text-center">
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Cabut akses user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-black text-[10px] uppercase tracking-tighter border border-red-100 px-4 py-1.5 rounded-lg hover:bg-red-50 transition shadow-sm">
                                                Hapus Akses
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 italic">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="bg-amber-900/5 p-4 text-center">
                    <p class="text-[9px] font-bold text-amber-900/30 uppercase tracking-[0.5em]">Sistem Manajemen SDM - Mino Food Indonesia</p>
                </div>
            </div>

        </div>
    </div>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-app-layout>