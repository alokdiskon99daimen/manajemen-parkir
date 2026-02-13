<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Membership
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('membership.store') }}" class="space-y-4" onsubmit="return confirm('Apakah anda yakin?')">
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
                    <input type="number" name="loyalty_point" onkeyup="if(this.value < 0) this.value = '';"
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
                        class="w-full border rounded px-3 py-2 plat-nomor"
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
</script>
