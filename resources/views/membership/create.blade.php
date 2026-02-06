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

                <div class="relative">
                    <label class="block text-sm font-medium mb-1">
                        Kendaraan (Plat Nomor)
                    </label>

                    <input
                        type="text"
                        id="plat_kendaraan"
                        class="w-full border rounded px-3 py-2"
                        placeholder="Ketik plat nomor..."
                        autocomplete="off"
                    >

                    {{-- DROPDOWN HASIL --}}
                    <div
                        id="kendaraanDropdown"
                        class="absolute z-10 w-full border bg-white rounded shadow-md hidden max-h-56 overflow-y-auto">
                    </div>
                </div>

                {{-- LIST KENDARAAN TERPILIH --}}
                <div id="kendaraanTerpilih" class="space-y-2"></div>
                <div id="kendaraanHidden"></div>

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


<script>
const input = document.getElementById('plat_kendaraan');
const dropdown = document.getElementById('kendaraanDropdown');
const list = document.getElementById('kendaraanTerpilih');
const hidden = document.getElementById('kendaraanHidden');

let kendaraanDipilih = new Map(); // id => plat

input.addEventListener('keyup', async function () {
    const q = this.value;

    if (q.length < 2) {
        dropdown.classList.add('hidden');
        return;
    }

    const res = await fetch(`/ajax/kendaraan?q=${q}`);
    const data = await res.json();

    dropdown.innerHTML = '';

    if (data.length === 0) {
        dropdown.classList.add('hidden');
        return;
    }

    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
        div.innerText = item.text;

        div.onclick = () => {
            if (!kendaraanDipilih.has(item.id)) {
                kendaraanDipilih.set(item.id, item.text);
                renderKendaraan();
            }

            input.value = '';
            dropdown.classList.add('hidden');
        };

        dropdown.appendChild(div);
    });

    dropdown.classList.remove('hidden');
});

document.addEventListener('click', function (e) {
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function renderKendaraan() {
    list.innerHTML = '';
    hidden.innerHTML = '';

    kendaraanDipilih.forEach((plat, id) => {
        // badge
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded';

        div.innerHTML = `
            <span class="text-sm">${plat}</span>
            <button type="button"
                class="text-red-600 text-sm hover:underline">
                Hapus
            </button>
        `;

        div.querySelector('button').onclick = () => {
            kendaraanDipilih.delete(id);
            renderKendaraan();
        };

        list.appendChild(div);

        // hidden input
        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = 'kendaraan[]';
        inputHidden.value = id;

        hidden.appendChild(inputHidden);
    });
}
</script>
