<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Diskon
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" onsubmit="return confirm('Apakah anda yakin?')"
                  action="{{ route('diskon.update', $diskon->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Nama Diskon</label>
                    <input type="text" name="nama_diskon"
                           value="{{ $diskon->nama_diskon }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Diskon (%)</label>
                    <input type="number" name="diskon" onkeyup="if(this.value < 0) this.value = '';"
                           value="{{ $diskon->diskon }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Waktu Mulai</label>
                    <input type="date" name="waktu_mulai"
                        value="{{ optional($diskon->waktu_mulai)->format('Y-m-d') }}"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Waktu Selesai</label>
                    <input type="date" name="waktu_selesai"
                        value="{{ optional($diskon->waktu_selesai)->format('Y-m-d') }}"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('diskon.index') }}" class="px-4 py-2 border rounded">
                        Batal
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
