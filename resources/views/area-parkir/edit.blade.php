<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Area Parkir
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST"
                  action="{{ route('area-parkir.update', $area->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Area
                    </label>
                    <input type="text" name="nama_area"
                           value="{{ old('nama_area', $area->nama_area) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Lokasi
                    </label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi', $area->lokasi) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Kapasitas
                    </label>
                    <input type="number" name="kapasitas"
                           value="{{ old('kapasitas', $area->kapasitas) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('area-parkir.index') }}"
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
