<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Track Area Parkir') }}
        </h2>
    </x-slot>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($areas as $area)
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-bold">
                        {{ $area['nama_area'] }}
                    </h3>
                    <span class="px-3 py-1 text-xs text-white rounded {{ $area['badge'] }}">
                        {{ $area['kondisi'] }}
                    </span>
                </div>

                <p class="text-sm text-gray-500 mb-4">
                    {{ $area['lokasi'] }}
                </p>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Kapasitas</span>
                        <span class="font-semibold">{{ $area['kapasitas'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Terisi</span>
                        <span class="font-semibold text-blue-600">{{ $area['terisi'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tersisa</span>
                        <span class="font-semibold text-green-600">{{ $area['tersisa'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
