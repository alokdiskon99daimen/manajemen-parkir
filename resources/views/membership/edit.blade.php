<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Membership
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST"
                  action="{{ route('membership.update', $membership->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama_lengkap"
                           value="{{ old('nama_lengkap', $membership->nama_lengkap) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Membership Tier
                    </label>
                    <select name="membership_tier_id"
                            class="w-full border rounded px-3 py-2 text-sm"
                            required>
                        <option value="">-- Pilih Tier --</option>
                        @foreach ($tiers as $tier)
                            <option value="{{ $tier->id }}"
                                {{ $membership->membership_tier_id == $tier->id ? 'selected' : '' }}>
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
                           value="{{ old('loyalty_point', $membership->loyalty_point) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Expired
                    </label>
                    <input type="date" name="expired"
                           value="{{ old('expired', \Carbon\Carbon::parse($membership->expired)->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="aktif" value="1"
                        {{ old('aktif', $membership->aktif) ? 'checked' : '' }}>
                    Aktif
                </label>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Kendaraan (Plat Nomor)
                    </label>

                    <input type="text"
                        id="search-kendaraan"
                        placeholder="Cari plat nomor..."
                        class="w-full border px-3 py-2 rounded">

                    <div id="kendaraan-result"
                        class="border mt-1 rounded bg-white hidden"></div>

                    <div id="kendaraan-terpilih"
                        class="mt-3 space-y-2"></div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('membership.index') }}"
                       class="px-4 py-2 rounded border">
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
                <script>
                    const kendaraanAwal = @json(
                        $membership->kendaraan->map(fn ($k) => [
                            'id' => $k->id,
                            'plat' => $k->plat_nomor
                        ])
                    );
                </script>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
const input = document.getElementById('search-kendaraan');
const resultBox = document.getElementById('kendaraan-result');
const container = document.getElementById('kendaraan-terpilih');

let kendaraanDipilih = new Map();

/* preload kendaraan lama */
kendaraanAwal.forEach(item => {
    kendaraanDipilih.set(item.id, item.plat);
});
renderKendaraan();

/* search */
input.addEventListener('keyup', async function () {
    const q = this.value;
    if (q.length < 2) {
        resultBox.classList.add('hidden');
        return;
    }

    const res = await fetch(`/ajax/kendaraan?q=${q}`);
    const data = await res.json();

    resultBox.innerHTML = '';
    resultBox.classList.remove('hidden');

    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
        div.textContent = item.text;

        div.onclick = () => {
            if (!kendaraanDipilih.has(item.id)) {
                kendaraanDipilih.set(item.id, item.text);
                renderKendaraan();
            }
            input.value = '';
            resultBox.classList.add('hidden');
        };

        resultBox.appendChild(div);
    });
});

/* render kendaraan */
function renderKendaraan() {
    container.innerHTML = '';

    kendaraanDipilih.forEach((plat, id) => {
        const row = document.createElement('div');
        row.className = 'flex justify-between items-center border px-3 py-2 rounded';

        row.innerHTML = `
            <span>${plat}</span>
            <input type="hidden" name="kendaraan[]" value="${id}">
            <button type="button"
                    class="text-red-600 text-sm">
                Hapus
            </button>
        `;

        row.querySelector('button').onclick = () => {
            kendaraanDipilih.delete(id);
            renderKendaraan();
        };

        container.appendChild(row);
    });
}
</script>
