<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Kendaraan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST"
                  action="{{ route('data-kendaraan.update', $dataKendaraan->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                {{-- TIPE KENDARAAN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tipe Kendaraan
                    </label>

                    <select name="id_tipe_kendaraan"
                            class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Tipe Kendaraan --</option>

                        @foreach ($tipeKendaraan as $tipe)
                            <option value="{{ $tipe->id }}"
                                {{ old('id_tipe_kendaraan', $dataKendaraan->id_tipe_kendaraan) == $tipe->id ? 'selected' : '' }}>
                                {{ $tipe->tipe_kendaraan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PLAT NOMOR --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                    <input type="text"
                           name="plat_nomor"
                           value="{{ old('plat_nomor', $dataKendaraan->plat_nomor) }}"
                           class="w-full border px-3 py-2 rounded uppercase">
                </div>

                {{-- WARNA --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Warna</label>
                    <input type="text"
                           name="warna"
                           value="{{ old('warna', $dataKendaraan->warna) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                {{-- PEMILIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pemilik</label>
                    <input type="text"
                           name="pemilik"
                           value="{{ old('pemilik', $dataKendaraan->pemilik) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                {{-- AKTIF --}}
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="aktif" value="1"
                        {{ old('aktif', $dataKendaraan->aktif) ? 'checked' : '' }}>
                    Aktif
                </label>

                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('data-kendaraan.index') }}"
                       class="px-4 py-2 rounded border">
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
