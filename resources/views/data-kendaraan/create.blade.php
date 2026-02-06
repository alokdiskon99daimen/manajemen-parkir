<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Kendaraan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('data-kendaraan.store') }}" class="space-y-4">
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
                           class="w-full border px-3 py-2 rounded uppercase">

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
</x-app-layout>
