<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Area Parkir
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('area-parkir.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Area
                    </label>
                    <input type="text" name="nama_area"
                           value="{{ old('nama_area') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Lokasi
                    </label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div id="detailWrapper">
                    <label class="block text-sm font-medium text-gray-700">
                        Tipe Kendaraan
                    </label>
                    <div class="flex gap-2 mb-2">
                        <input name="tipe_kendaraan[]" placeholder="Motor / Mobil"
                            class="w-1/2 border px-3 py-2 rounded">
                        <input name="kapasitas[]" type="number" placeholder="Kapasitas"
                            class="w-1/2 border px-3 py-2 rounded">
                    </div>
                </div>

                <button type="button" onclick="addDetail()"
                        class="text-sm text-blue-600">+ Tambah Tipe</button>

                        @if($errors->has('tipe_kendaraan'))
                            <p class="text-sm text-red-600">
                                {{ $errors->first('tipe_kendaraan') }}
                            </p>
                        @endif

                <div class="flex justify-end gap-2">
                    <a href="{{ route('area-parkir.index') }}"
                       class="px-4 py-2 rounded border">
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
function addDetail(){
    document.getElementById('detailWrapper').insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 mb-2 detail-row">
            <input name="tipe_kendaraan[]" class="w-1/2 border px-3 py-2 rounded">
            <input name="kapasitas[]" type="number"
                   class="w-1/2 border px-3 py-2 rounded">
            <button type="button"
                    onclick="removeRow(this)"
                    class="text-red-600 text-sm">
                ✕
            </button>
        </div>
    `);
}

function removeRow(btn){
    btn.closest('.detail-row').remove();
}
</script>
