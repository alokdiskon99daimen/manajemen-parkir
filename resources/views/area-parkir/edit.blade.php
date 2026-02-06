<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Area Parkir
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('area-parkir.update', $area->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Area</label>
                    <input type="text" name="nama_area"
                           value="{{ old('nama_area', $area->nama_area) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi', $area->lokasi) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div id="detailWrapper">
                    <label class="block text-sm font-medium text-gray-700">Tipe Kendaraan</label>
                    @foreach($area->details as $detail)
                        <div class="flex gap-2 mb-2 detail-row">
                            <select name="tipe_kendaraan[]" class="w-1/2 border px-3 py-2 rounded">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($tipeKendaraan as $tipe)
                                    <option value="{{ $tipe->id }}"
                                        {{ $detail->id_tipe_kendaraan == $tipe->id ? 'selected' : '' }}>
                                        {{ $tipe->tipe_kendaraan }}
                                    </option>
                                @endforeach
                            </select>

                            <input name="kapasitas[]" type="number"
                                value="{{ $detail->kapasitas }}"
                                class="w-1/2 border px-3 py-2 rounded">

                            @if($detail->terisi == 0)
                                <button type="button" onclick="removeRow(this)" class="text-red-600 text-sm">✕</button>
                            @else
                                <span class="text-xs text-gray-400 self-center">Terisi</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="addDetail()" class="text-sm text-blue-600">+ Tambah Tipe</button>

                @if($errors->has('tipe_kendaraan'))
                    <p class="text-sm text-red-600">{{ $errors->first('tipe_kendaraan') }}</p>
                @endif

                <div class="flex justify-end gap-2">
                    <a href="{{ route('area-parkir.index') }}" class="px-4 py-2 rounded border">Batal</a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
function addDetail(){
    let options = `@foreach($tipeKendaraan as $tipe)
        <option value="{{ $tipe->id }}">{{ $tipe->tipe_kendaraan }}</option>
    @endforeach`;

    document.getElementById('detailWrapper').insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 mb-2 detail-row">
            <select name="tipe_kendaraan[]" class="w-1/2 border px-3 py-2 rounded">
                <option value="">-- Pilih Tipe --</option>
                ${options}
            </select>
            <input name="kapasitas[]" type="number" placeholder="Kapasitas"
                   class="w-1/2 border px-3 py-2 rounded">
            <button type="button" onclick="removeRow(this)" class="text-red-600 text-sm">✕</button>
        </div>
    `);
}

function removeRow(btn){
    btn.closest('.detail-row').remove();
}

</script>
