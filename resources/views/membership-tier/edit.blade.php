<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Membership Tier
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST"
                  action="{{ route('membership-tier.update', $membershipTier->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Tier</label>
                    <input type="text" name="tier"
                           value="{{ $membershipTier->tier }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Harga / Bulan</label>
                    <input type="number" name="harga"
                        value="{{ $membershipTier->harga }}"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Diskon (%)</label>
                    <input type="number" name="diskon"
                           value="{{ $membershipTier->diskon }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Free Entry</label>
                    <input type="number" name="free_entry"
                           value="{{ $membershipTier->free_entry }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('membership-tier.index') }}" class="px-4 py-2 border rounded">
                        Batal
                    </a>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
