<x-guest-layout>
    <!-- CSS UNTUK MEMAKSA BACKGROUND MUNCUL -->
    <style>
        body, .min-h-screen {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                              url("{{ asset('images/bg-cafe.jpg') }}") !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
        }

        div[class*="bg-slate-"], div[class*="bg-gray-"], main {
            background-color: transparent !important;
        }

        .login-card {
            background-color: rgba(15, 23, 41, 0.75) !important;
            backdrop-filter: blur(12px) !important;
        }

        /* Tambahan Style agar link lebih terlihat saat di-hover */
        .hover-link:hover {
            text-decoration: underline;
            color: #fad660 !important; /* Biru terang */
        }
    </style>

    <div class="flex flex-col md:flex-row items-center justify-center min-h-screen w-full px-6 md:px-20 gap-10 md:gap-24">
        
        <!-- BAGIAN KIRI: Teks -->
        <div class="text-white max-w-lg hidden md:block">
            <div class="bg-blue-600/30 backdrop-blur-sm p-3 rounded-xl w-fit mb-6">
               <span class="text-4xl">📦</span>
            </div>
            <h1 class="text-6xl font-extrabold leading-tight tracking-tight">
                Manajemen Gudang <br>
                <span class="text-blue-400 italic font-medium text-5xl">Mino Food Indonesia</span>
            </h1>
            <p class="mt-6 text-gray-100 text-xl leading-relaxed">
                Optimalkan pencatatan barang masuk dan keluar dengan sistem yang terintegrasi untuk Owner, Admin, dan Staff.
            </p>
            <div class="mt-8 flex gap-4 text-xs font-bold tracking-widest text-blue-200/60 uppercase">
                <span>Admin</span> • <span>Owner</span> • <span>Staff User</span>
            </div>
        </div>

        <!-- BAGIAN KANAN: Form Login -->
        <div class="login-card w-full sm:max-w-md px-8 py-12 border border-white/10 shadow-2xl rounded-3xl">
            
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Selamat Datang</h2>
                <p class="text-gray-400 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full bg-slate-800/50 border-gray-600 text-white rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 outline-none transition"
                           placeholder="email@minofood.id">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Password</label>
                    <input id="password" type="password" name="password" required 
                           class="w-full bg-slate-800/50 border-gray-600 text-white rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 outline-none transition"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-800 border-gray-600 text-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-400">Ingat saya</span>
                    </label>

                    <!-- PERBAIKAN: Link Lupa Password -->
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-400 hover-link font-medium transition" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full mt-8 bg-white text-slate-950 font-black py-4 rounded-xl hover:bg-blue-50 transition-all duration-300 uppercase tracking-widest shadow-lg shadow-white/5">
                    Masuk Sistem
                </button>

                <!-- PERBAIKAN: Hubungi Admin (Link WhatsApp) -->
                <p class="mt-8 text-center text-xs text-gray-500">
                    Belum punya akses? 
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20meminta%20akses%20ke%20Sistem%20Gudang%20Mino%20Food." 
                       target="_blank"
                       class="text-blue-400 font-bold hover-link transition">
                        Hubungi Admin
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>