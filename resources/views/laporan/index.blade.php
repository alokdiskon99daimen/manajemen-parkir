<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-6 flex flex-col gap-4 space mx-60">
        <!-- Laporan Harian (Blue/Primary) -->
        <a href="{{ route('laporan.harian') }}" 
        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Laporan Harian
        </a>

        <!-- Laporan Rentang Tanggal (Gray/Secondary) -->
        <a href="{{ route('laporan.range') }}" 
        class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Laporan Rentang Tanggal
        </a>

        <!-- Occupancy (Outline) -->
        <a href="{{ route('track-area-parkir') }}" 
        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            Occupancy
        </a>
    </div>
</x-app-layout>
