<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Membership
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('membership.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama_lengkap"
                           value="{{ old('nama_lengkap') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Membership Tier
                    </label>
                    <select name="membership_tier_id"
                            class="w-full border rounded px-3 py-2 text-sm"
                            required>
                        <option value="">-- Pilih Tier --</option>
                        @foreach ($tiers as $tier)
                            <option value="{{ $tier->id }}">
                                {{ $tier->tier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Loyalty Point
                    </label>
                    <input type="number" name="loyalty_point"
                           value="{{ old('loyalty_point') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Expired
                    </label>
                    <input type="date" name="expired"
                           value="{{ old('expired') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="aktif" value="1" checked>
                    Aktif
                </label>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('membership.index') }}"
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
