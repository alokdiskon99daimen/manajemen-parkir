<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tracking Area Parkir
        </h2>
    </x-slot>

    <div class="py-8">
        {{-- GRID WRAPPER --}}
        <div
            id="tracking-area"
            class="max-w-7xl mx-auto grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6"
        >
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
                                        {{ $detail['tipe_kendaraan'] }}
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
                                        <span>Terisi ({{ $detail['persentase_terisi'] }}%)</span>
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

@push('scripts')
<script>
function loadTrackingArea() {
    fetch("{{ route('tracking-area.data') }}")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('tracking-area');
            container.innerHTML = '';

            data.forEach(area => {
                let detailHtml = '';

                if (area.details.length === 0) {
                    detailHtml = `
                        <p class="text-sm text-gray-400 italic">
                            Belum ada data tipe kendaraan
                        </p>`;
                } else {
                    area.details.forEach(d => {
                        detailHtml += `
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium text-gray-700">
                                    ${d.tipe_kendaraan}
                                </span>
                                <span class="text-xs text-white px-2 py-1 rounded ${d.badge}">
                                    ${d.kondisi}
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 space-y-1">
                                <div class="flex justify-between">
                                    <span>Kapasitas</span>
                                    <span>${d.kapasitas}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Terisi (${d.persentase_terisi}%)</span>
                                    <span>${d.terisi}</span>
                                </div>
                                <div class="flex justify-between font-semibold">
                                    <span>Tersisa</span>
                                    <span>${d.tersisa}</span>
                                </div>
                            </div>
                        </div>`;
                    });
                }

                container.innerHTML += `
                <div class="bg-white rounded-lg shadow p-5 border">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            ${area.nama_area}
                        </h3>
                        <p class="text-sm text-gray-500">
                            ${area.lokasi}
                        </p>
                    </div>

                    <div class="space-y-3">
                        ${detailHtml}
                    </div>
                </div>`;
            });
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadTrackingArea();
    setInterval(loadTrackingArea, 5000);
    console.log('Tracking area parkir auto-refresh every 5 seconds.');
});

</script>
@endpush
</x-app-layout>
