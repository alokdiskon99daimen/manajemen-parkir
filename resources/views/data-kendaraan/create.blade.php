<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Kendaraan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('data-kendaraan.store') }}" class="space-y-4" onsubmit="return confirm('Apakah anda yakin?')">
                @csrf

                {{-- TIPE KENDARAAN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tipe Kendaraan
                    </label>

                    <select name="id_tipe_kendaraan"
                            class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Tipe --</option>

                        @foreach ($tipeKendaraan as $tipe)
                            <option value="{{ $tipe->id }}"
                                {{ old('id_tipe_kendaraan') == $tipe->id ? 'selected' : '' }}>
                                {{ $tipe->tipe_kendaraan }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_tipe_kendaraan')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PLAT NOMOR --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                    <input type="text"
                           name="plat_nomor"
                           value="{{ old('plat_nomor') }}"
                           class="w-full border px-3 py-2 rounded plat-nomor">

                    @error('plat_nomor')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- WARNA --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Warna</label>
                    <input type="text"
                           name="warna"
                           value="{{ old('warna') }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                {{-- PEMILIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pemilik</label>
                    <input type="text"
                           name="pemilik"
                           value="{{ old('pemilik') }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                {{-- AKTIF --}}
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="aktif" value="1" checked>
                    Aktif
                </label>

                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('data-kendaraan.index') }}"
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

@push('scripts')
<script>
document.querySelectorAll('.plat-nomor').forEach(input => {
    input.addEventListener('input', function (e) {

        let value = e.target.value.toUpperCase();

        // hapus karakter selain huruf & angka
        value = value.replace(/[^A-Z0-9]/g, '');

        let hurufDepan = '';
        let angka = '';
        let hurufBelakang = '';

        for (let char of value) {

            // 🚫 karakter pertama WAJIB huruf
            if (hurufDepan.length === 0 && !/[A-Z]/.test(char)) {
                continue;
            }

            // isi huruf depan (max 2)
            if (hurufDepan.length < 2 && /[A-Z]/.test(char) && angka.length === 0) {
                hurufDepan += char;
                continue;
            }

            // isi angka (max 4)
            if (angka.length < 4 && /[0-9]/.test(char)) {
                angka += char;
                continue;
            }

            // isi huruf belakang (max 3)
            if (hurufBelakang.length < 3 && /[A-Z]/.test(char) && angka.length > 0) {
                hurufBelakang += char;
            }
        }

        let result = hurufDepan;

        if (angka.length > 0) {
            result += ' ' + angka;
        }

        if (hurufBelakang.length > 0) {
            result += ' ' + hurufBelakang;
        }

        e.target.value = result.trim();
    });
});

function isPlatValid(value) {
    // regex HURUF → ANGKA → HURUF (akhir opsional)
    const regex = /^[A-Z]{1,2}\s[0-9]{1,4}\s[A-Z]{1,3}$/;
    return regex.test(value.trim());
}

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function (e) {

        const platInput = form.querySelector('.plat-nomor');
        if (!platInput) return;

        const value = platInput.value.trim();

        if (!isPlatValid(value)) {
            e.preventDefault();
            alert(
                'Format plat nomor tidak valid.\n\n' +
                'Gunakan format:\n' +
                'B 1234 XYZ\n' 
            );
            platInput.focus();
        }
    });
});
</script>
@endpush
</x-app-layout>