<header class="sticky top-0 z-40 flex items-center justify-between px-4 md:px-8 py-3.5 bg-white/80 backdrop-blur-lg border-b border-slate-200/60 shadow-sm">
    <div class="flex items-center">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden p-2 rounded-md hover:bg-slate-100 transition mr-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <h2 class="text-xl font-bold text-slate-800 hidden md:block">
            Sistem Informasi <span class="text-green-700">Kelurahan</span>
        </h2>
    </div>

    <!-- Top Right Area -->
    <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-green-600 transition bg-slate-50 px-3 py-1.5 rounded-md border border-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Website
        </a>
        
        <div class="h-6 w-px bg-slate-200 hidden md:block"></div>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 focus:outline-none hover:bg-slate-50 p-1.5 rounded-lg transition">
                <div class="flex flex-col text-right hidden sm:flex">
                    <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] font-extrabold text-green-600 uppercase tracking-wider">{{ auth()->user()->role ?? 'Admin' }}</span>
                </div>
                <img class="w-9 h-9 object-cover rounded-full border-2 border-slate-200" src="{{ auth()->user() && auth()->user()->avatar ? (str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : Storage::url(auth()->user()->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'A') . '&color=15803d&background=f0fdf4' }}" alt="Avatar">
                <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="userMenuOpen" 
                 x-transition:enter="transition ease-out duration-100" 
                 x-transition:enter-start="transform opacity-0 scale-95" 
                 x-transition:enter-end="transform opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-75" 
                 x-transition:leave-start="transform opacity-100 scale-100" 
                 x-transition:leave-end="transform opacity-0 scale-95" 
                 class="absolute right-0 w-48 mt-2 origin-top-right bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-slate-100/50 z-50 overflow-hidden ring-1 ring-black ring-opacity-5" 
                 style="display: none;" x-cloak>
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 sm:hidden">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs font-medium text-slate-500 uppercase">{{ auth()->user()->role ?? 'Admin' }}</p>
                </div>
                <a href="{{ route('dashboard.settings.profile') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700 font-medium transition">Profil Saya</a>
                <a href="{{ route('dashboard.settings.index') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700 font-medium transition">Pengaturan</a>
            </div>
        </div>
    </div>
</header>
