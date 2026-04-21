<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    
    <!-- ================= CONTAINER ================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- ================= LEFT ================= -->
            <div class="flex">

                <!-- LOGO -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- MENU -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- ================= ADMIN ================= --}}
                    @if(auth()->user()->role === 'admin')

                        <x-nav-link 
                            :href="route('books.index')" 
                            :active="request()->routeIs('books.*')">
                            Manajemen Buku
                        </x-nav-link>

                        <x-nav-link 
                            :href="route('admin.borrowings')" 
                            :active="request()->routeIs('admin.borrowings')">
                            Data Peminjaman
                        </x-nav-link>

                    @endif


                    {{-- ================= SISWA ================= --}}
                    @if(auth()->user()->role === 'anggota')

                        <x-nav-link 
                            :href="route('anggota.dashboard')" 
                            :active="request()->routeIs('anggota.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link 
                            :href="route('riwayat')" 
                            :active="request()->routeIs('riwayat')">
                            Riwayat Peminjaman
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- ================= RIGHT ================= -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <x-dropdown align="right" width="48">
                    
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-600 hover:text-gray-800">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                ▼
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- ================= HAMBURGER ================= -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-600">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- ================= MOBILE ================= -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            {{-- ================= ADMIN ================= --}}
            @if(auth()->user()->role === 'admin')

                <x-responsive-nav-link 
                    :href="route('books.index')" 
                    :active="request()->routeIs('books.*')">
                    Manajemen Buku
                </x-responsive-nav-link>

                <x-responsive-nav-link 
                    :href="route('admin.borrowings')" 
                    :active="request()->routeIs('admin.borrowings')">
                    Data Peminjaman
                </x-responsive-nav-link>
                

            @endif


            {{-- ================= SISWA ================= --}}
            @if(auth()->user()->role === 'anggota')

                <x-responsive-nav-link 
                    :href="route('anggota.dashboard')" 
                    :active="request()->routeIs('anggota.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link 
                    :href="route('riwayat')" 
                    :active="request()->routeIs('riwayat')">
                    Riwayat Peminjaman
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- ================= MOBILE PROFILE ================= -->
        <div class="pt-4 pb-1 border-t">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>

            </div>

        </div>
    </div>
</nav>