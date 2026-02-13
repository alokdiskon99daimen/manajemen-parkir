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
                        class="w-full border rounded px-3 py-2 plat-masuk plat-nomor"
                        placeholder="B 1234 XYZ"
                        autocomplete="off"
                    >

                    {{-- DROPDOWN HASIL --}}
                    <div class="plat-dropdown absolute z-10 w-full border bg-white rounded shadow-md hidden max-h-56 overflow-y-auto"></div>
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
                        <input type="hidden" name="id_tipe_kendaraan" id="id_tipe_kendaraan_hidden">
                    </div>

                    <div>
                        <label class="text-sm">Warna (opsional)</label>
                        <input type="text" name="warna" id="warna" class="w-full border rounded px-2 py-1">
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm">Pemilik (opsional)</label>
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

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin ingin mencatat kendaraan ini sebagai MASUK parkir?')">
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

                <div class="mb-3">
                    <button type="button"
                        id="openScanner"
                        class="bg-blue-600 text-white px-3 py-2 rounded text-sm">
                        📷 Scan QR
                    </button>
                </div>

                <div id="reader" class="hidden mt-3"></div>

                <div class="mb-3 relative">
                    <label class="block text-sm font-medium">Plat Nomor</label>
                    <input
                        type="text"
                        name="plat_nomor"
                        class="w-full border rounded px-3 py-2 plat-nomor plat-keluar"
                        placeholder="B 1234 XYZ"
                        autocomplete="off"
                        required
                    >

                    <div class="plat-dropdown absolute z-10 w-full border bg-white rounded shadow-md hidden max-h-56 overflow-y-auto"></div>
                </div>

                <div class="mb-3 relative">
                    <label class="text-sm">Metode Pembayaran</label>

                    <select
                        name="id_metode_pembayaran"
                        id="id_metode_pembayaran"
                        class="w-full border rounded px-2 py-1"
                        required
                    >
                        <option value="">-- Pilih Metode Pembayaran --</option>

                        @foreach ($metodePembayaran as $metode)
                            <option value="{{ $metode->id }}">
                                {{ $metode->metode_pembayaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 relative">
                    <label class="text-sm">Diskon</label>

                    <select
                        name="diskon"
                        id="diskon"
                        class="w-full border rounded px-2 py-1"
                    >

                        @foreach ($diskon as $d)
                            <option value="{{ $d->id }}" {{ $loop->first ? 'selected' : '' }}>
                                {{ $d->nama_diskon }} ({{ $d->diskon }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin ingin mencatat kendaraan ini sebagai KELUAR parkir?')">
                    Generate Tiket Keluar
                </button>
            </form>
        </div>

    </div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
    document.getElementById("openScanner").addEventListener("click", function () {

        const reader = document.getElementById("reader");
        reader.classList.remove("hidden");

        const html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                html5QrCode.start(
                    devices[0].id,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {

                        try {
                            let data = JSON.parse(qrCodeMessage);

                        if (data.plat_nomor) {
                            document.querySelector(".plat-keluar").value = data.plat_nomor;
                        }

                        } catch (e) {
                            document.querySelector(".plat-keluar").value = qrCodeMessage;
                        }

                        html5QrCode.stop();
                        reader.classList.add("hidden");
                    },
                    errorMessage => {
                    }
                );
            }
        });
    });
    </script>
</x-app-layout>

<script>
const platInput = document.getElementById('plat_nomor');
const dropdown = document.getElementById('platDropdown');

document.querySelectorAll('.plat-nomor').forEach(input => {

    const dropdown = input.parentElement.querySelector('.plat-dropdown');

    input.addEventListener('keyup', async function () {
        const q = this.value.trim();

        if (q.length < 2) {
            dropdown.classList.add('hidden');
            lockVehicleFields(false);
            return;
        }

        const res = await fetch(`/kendaraan/search?q=${q}`);
        const data = await res.json();

        dropdown.innerHTML = '';

        if (data.length === 0) {
            dropdown.classList.add('hidden');
            lockVehicleFields(false);
            return;
        }

        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
            div.textContent = item.plat_nomor;

            div.onclick = () => {
                input.value = item.plat_nomor;

                // 🎯 KHUSUS TIKET MASUK
                if (input.classList.contains('plat-masuk')) {
                    document.getElementById('id_tipe_kendaraan').value = item.id_tipe_kendaraan;
                    document.getElementById('id_tipe_kendaraan_hidden').value = item.id_tipe_kendaraan;
                    document.getElementById('warna').value = item.warna ?? '';
                    document.getElementById('pemilik').value = item.pemilik ?? '';
                    loadAreaByTipe(item.id_tipe_kendaraan);
                    lockVehicleFields(true);
                }

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


// a
document.querySelectorAll('.plat-nomor').forEach(input => {
    input.addEventListener('input', function (e) {

        let value = e.target.value.toUpperCase();

        // hapus karakter selain huruf & angka
        value = value.replace(/[^A-Z0-9]/g, '');

        let hurufDepan = '';
        let angka = '';
        let hurufBelakang = '';

        for (let char of value) {

            // 🚫 karakter pertama WAJIB huruf
            if (hurufDepan.length === 0 && !/[A-Z]/.test(char)) {
                continue;
            }

            // isi huruf depan (max 2)
            if (hurufDepan.length < 2 && /[A-Z]/.test(char) && angka.length === 0) {
                hurufDepan += char;
                continue;
            }

            // isi angka (max 4)
            if (angka.length < 4 && /[0-9]/.test(char)) {
                angka += char;
                continue;
            }

            // isi huruf belakang (max 3)
            if (hurufBelakang.length < 3 && /[A-Z]/.test(char) && angka.length > 0) {
                hurufBelakang += char;
            }
        }

        let result = hurufDepan;

        if (angka.length > 0) {
            result += ' ' + angka;
        }

        if (hurufBelakang.length > 0) {
            result += ' ' + hurufBelakang;
        }

        e.target.value = result.trim();
    });
});

function isPlatValid(value) {
    // regex HURUF → ANGKA → HURUF (akhir opsional)
    const regex = /^[A-Z]{1,2}\s[0-9]{1,4}\s[A-Z]{1,3}$/;
    return regex.test(value.trim());
}

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function (e) {

        const platInput = form.querySelector('.plat-nomor');
        if (!platInput) return;

        const value = platInput.value.trim();

        if (!isPlatValid(value)) {
            e.preventDefault();
            alert(
                'Format plat nomor tidak valid.\n\n' +
                'Gunakan format:\n' +
                'B 1234 XYZ\n' 
            );
            platInput.focus();
        }
    });
});

function lockVehicleFields(lock = true) {
    document.getElementById('id_tipe_kendaraan').disabled = lock;
    document.getElementById('warna').readOnly = lock;
    document.getElementById('pemilik').readOnly = lock;
}
</script>