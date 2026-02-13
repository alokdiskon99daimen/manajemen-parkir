<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Membership Tier
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('membership-tier.store') }}" class="space-y-4" onsubmit="return confirm('Apakah anda yakin?')">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tier</label>
                    <input type="text" name="tier"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Harga / Bulan
                    </label>
                    <input type="number" name="harga" onkeyup="if(this.value < 0) this.value = '';"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Diskon (%)</label>
                    <input type="number" name="diskon" onkeyup="if(this.value < 0) this.value = '';"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Free Entry</label>
                    <input type="number" name="free_entry" onkeyup="if(this.value < 0) this.value = '';"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('membership-tier.index') }}" class="px-4 py-2 border rounded">
                        Batal
                    </a>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
