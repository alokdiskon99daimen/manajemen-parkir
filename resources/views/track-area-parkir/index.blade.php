<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tracking Area Parkir
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($areas as $area)
                {{-- CARD AREA --}}
                <div class="bg-white rounded-lg shadow p-5 border">

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $area['nama_area'] }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $area['lokasi'] }}
                        </p>
                    </div>

                    {{-- CARD TIPE KENDARAAN --}}
                    <div class="space-y-3">
                        @foreach ($area['details'] as $detail)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-700">
                                        {{ ucfirst($detail['tipe_kendaraan']) }}
                                    </span>
                                    <span class="text-xs text-white px-2 py-1 rounded {{ $detail['badge'] }}">
                                        {{ $detail['kondisi'] }}
                                    </span>
                                </div>

                                <div class="text-sm text-gray-600 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Kapasitas</span>
                                        <span>{{ $detail['kapasitas'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Terisi</span>
                                        <span>{{ $detail['terisi'] }}</span>
                                    </div>
                                    <div class="flex justify-between font-semibold">
                                        <span>Tersisa</span>
                                        <span>{{ $detail['tersisa'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($area['details']->isEmpty())
                            <p class="text-sm text-gray-400 italic">
                                Belum ada data tipe kendaraan
                            </p>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
