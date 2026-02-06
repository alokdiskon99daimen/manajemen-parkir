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
                <div class="mb-3 relative">
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
                    <div id="platDropdown"
                        class="absolute z-10 w-full border bg-white rounded shadow-md hidden max-h-56 overflow-y-auto">
                    </div>
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

                    <div>
                        <label class="text-sm">Area Parkir</label>
                        <select
                            name="id_area"
                            id="id_area"
                            class="w-full border rounded px-2 py-1"
                            required
                            disabled
                        >
                            <option value="">-- Pilih Area Parkir --</option>
                        </select>
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

            {{-- ERROR GLOBAL --}}
            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
            tipeSelect.value = String(item.id_tipe_kendaraan);
            loadAreaByTipe(String(item.id_tipe_kendaraan));           
            document.getElementById('warna').value = item.warna;
            document.getElementById('pemilik').value = item.pemilik;
            dropdown.classList.add('hidden');
        };

        dropdown.appendChild(div);
    });

    dropdown.classList.remove('hidden');
});

document.addEventListener('click', function (e) {
    if (
        !platInput.contains(e.target) &&
        !dropdown.contains(e.target)
    ) {
        dropdown.classList.add('hidden');
    }
});


const tipeSelect = document.getElementById('id_tipe_kendaraan');
const areaSelect = document.getElementById('id_area');

async function loadAreaByTipe(tipeId) {
    areaSelect.innerHTML = '<option value="">-- Pilih Area Parkir --</option>';

    if (!tipeId) {
        areaSelect.disabled = true;
        return;
    }

    const res = await fetch(`/area/by-tipe/${tipeId}`);
    const data = await res.json();

    if (data.length === 0) {
        areaSelect.disabled = true;
        return;
    }

    data.forEach(area => {
        const opt = document.createElement('option');
        opt.value = area.id;
        opt.textContent = `${area.nama_area} (Tersisa: ${area.tersisa})`;

        if (area.tersisa === 0) {
            opt.disabled = true;
            opt.style.color = 'red';
            opt.textContent += ' - Penuh';
        }

        areaSelect.appendChild(opt);
    });

    areaSelect.disabled = false;
}


tipeSelect.addEventListener('change', function () {
    loadAreaByTipe(this.value);
});
</script>