<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Tarif
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('tarif.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tipe Kendaraan
                    </label>

                    <select name="id_tipe_kendaraan"
                            class="w-full border px-3 py-2 rounded"
                            required>
                        <option value="">-- Pilih Tipe --</option>

                        @foreach ($tipeKendaraan as $tipe)
                            <option value="{{ $tipe->id }}"
                                {{ old('id_tipe_kendaraan') == $tipe->id ? 'selected' : '' }}>
                                {{ $tipe->tipe_kendaraan }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_tipe_kendaraan')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tarif Per Jam
                    </label>
                    <input type="number" name="tarif_per_jam"
                           value="{{ old('tarif_per_jam') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tarif_per_jam')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('tarif.index') }}"
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
