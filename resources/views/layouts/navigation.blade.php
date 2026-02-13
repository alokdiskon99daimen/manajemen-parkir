<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex items-center justify-center h-9 w-9 bg-blue-600 rounded-lg">
                            <span class="text-white font-bold text-lg">MP</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    {{-- ADMIN --}}
                    @role('admin')
                        {{-- Master --}}
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 py-6 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition">
                                    Master
                                    <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21L10 12l4.77-4.79" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('user.index')">User</x-dropdown-link>
                                <x-dropdown-link :href="route('tarif.index')">Tarif</x-dropdown-link>
                                <x-dropdown-link :href="route('area-parkir.index')">Area Parkir</x-dropdown-link>
                                <x-dropdown-link :href="route('tipe-kendaraan.index')">Tipe Kendaraan</x-dropdown-link>
                                <x-dropdown-link :href="route('data-kendaraan.index')">Data Kendaraan</x-dropdown-link>
                                <x-dropdown-link :href="route('membership-tier.index')">Membership Tier</x-dropdown-link>
                                <x-dropdown-link :href="route('membership.index')">Membership</x-dropdown-link>
                                <x-dropdown-link :href="route('diskon.index')">Diskon</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        {{-- Log --}}
                        <x-nav-link :href="route('log-aktivitas.index')" :active="request()->routeIs('log-aktivitas.index')">
                            Log Aktivitas
                        </x-nav-link>

                        {{-- Transaksi --}}
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 py-6 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                                    Transaksi
                                    <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21L10 12l4.77-4.79"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('transaksi.aktif')">Transaksi Aktif</x-dropdown-link>
                                <x-dropdown-link :href="route('transaksi.riwayat')">Riwayat Transaksi</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endrole

                    {{-- UMUM --}}
                    <x-nav-link :href="route('track-area-parkir')" :active="request()->routeIs('track-area-parkir')">
                        Track Area
                    </x-nav-link>

                    <x-nav-link :href="route('monitoring-area-parkir')" :active="request()->routeIs('monitoring-area-parkir')">
                        Monitoring Area
                    </x-nav-link>

                    {{-- PETUGAS --}}
                    @role('Petugas Parkir')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 py-6 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                                    Transaksi
                                    <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21L10 12l4.77-4.79"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('transaksi.index')">Input Transaksi</x-dropdown-link>
                                <x-dropdown-link :href="route('transaksi.aktif')">Transaksi Aktif</x-dropdown-link>
                                <x-dropdown-link :href="route('transaksi.riwayat')">Riwayat</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endrole

                    {{-- OWNER --}}
                    @role('Owner/Manajemen')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 py-6 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                                    Laporan
                                    <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21L10 12l4.77-4.79"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('laporan.index')">Laporan</x-dropdown-link>
                                <x-dropdown-link :href="route('laporan.analytics')">Analytics</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @role('admin')
            <div class="px-4 pt-2 text-xs text-gray-400 uppercase">Master</div>
            <x-responsive-nav-link :href="route('user.index')">User</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tarif.index')">Tarif</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('area-parkir.index')">Area Parkir</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tipe-kendaraan.index')">Tipe Kendaraan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('membership.index')">Membership</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('diskon.index')">Diskon</x-responsive-nav-link>

            <div class="px-4 pt-2 text-xs text-gray-400 uppercase">Transaksi</div>
            <x-responsive-nav-link :href="route('transaksi.aktif')">Aktif</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transaksi.riwayat')">Riwayat</x-responsive-nav-link>
        @endrole

        @role('Petugas Parkir')
            <div class="px-4 pt-2 text-xs text-gray-400 uppercase">
                Transaksi
            </div>

            <x-responsive-nav-link :href="route('transaksi.index')">
                Input Transaksi
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('transaksi.aktif')">
                Transaksi Aktif
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('transaksi.riwayat')">
                Riwayat Transaksi
            </x-responsive-nav-link>
        @endrole

        <x-responsive-nav-link :href="route('track-area-parkir')">Track Area</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('monitoring-area-parkir')">Monitoring</x-responsive-nav-link>

        @role('Owner/Manajemen')
            <div class="px-4 pt-2 text-xs text-gray-400 uppercase">Laporan</div>
            <x-responsive-nav-link :href="route('laporan.index')">Laporan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laporan.analytics')">Analytics</x-responsive-nav-link>
        @endrole

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
