<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 m-6">
        {{-- TIKET MASUK --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">🎫 Tiket Masuk</h2>

            <form id="formMasuk" method="POST" action="{{ route('transaksi.masuk') }}">
                @csrf

                {{-- PLAT NOMOR --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium">Plat Nomor</label>
                    <input
                        type="text"
                        name="plat_nomor"
                        id="plat_nomor"
                        class="w-full border rounded px-3 py-2"
                        placeholder="B 1234 XYZ"
                        autocomplete="off"
                    >

                    {{-- DROPDOWN HASIL --}}
                    <div id="platDropdown" class="border bg-white hidden absolute z-10 w-full"></div>
                </div>

                {{-- DATA KENDARAAN --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm">Tipe Kendaraan</label>

                        <select
                            name="id_tipe_kendaraan"
                            id="id_tipe_kendaraan"
                            class="w-full border rounded px-2 py-1"
                            required
                        >
                            <option value="">-- Pilih Tipe Kendaraan --</option>

                            @foreach ($tipeKendaraan as $tipe)
                                <option value="{{ $tipe->id }}">
                                    {{ $tipe->tipe_kendaraan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm">Warna</label>
                        <input type="text" name="warna" id="warna" class="w-full border rounded px-2 py-1">
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm">Pemilik</label>
                        <input type="text" name="pemilik" id="pemilik" class="w-full border rounded px-2 py-1">
                    </div>
                </div>

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                    Generate Tiket Masuk
                </button>
            </form>
        </div>

        {{-- TIKET KELUAR --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">🎫 Tiket Keluar</h2>

            <form method="POST" action="{{ route('transaksi.keluar') }}">
                @csrf

                <label class="block text-sm font-medium">Plat Nomor</label>
                <input
                    type="text"
                    name="plat_nomor"
                    class="w-full border rounded px-3 py-2"
                    placeholder="B 1234 XYZ"
                    required
                >

                <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
                    Generate Tiket Keluar
                </button>
            </form>
        </div>

    </div>
</x-app-layout>

<script>
const platInput = document.getElementById('plat_nomor');
const dropdown = document.getElementById('platDropdown');

platInput.addEventListener('keyup', async function () {
    const q = this.value;

    if (q.length < 2) {
        dropdown.classList.add('hidden');
        return;
    }

    const res = await fetch(`/kendaraan/search?q=${q}`);
    const data = await res.json();

    dropdown.innerHTML = '';

    if (data.length === 0) {
        dropdown.classList.add('hidden');
        return;
    }

    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
        div.innerText = item.plat_nomor;

        div.onclick = () => {
            platInput.value = item.plat_nomor;
            document.getElementById('id_tipe_kendaraan').value = item.id_tipe_kendaraan;
            document.getElementById('warna').value = item.warna;
            document.getElementById('pemilik').value = item.pemilik;
            dropdown.classList.add('hidden');
        };

        dropdown.appendChild(div);
    });

    dropdown.classList.remove('hidden');
});
</script>

