<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Membership') }}
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        /* HEADER */
        #membershipTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        /* BODY */
        #membershipTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        /* ROW HOVER */
        #membershipTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        /* HILANGKAN style bawaan datatables */
        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('membership.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Membership
            </a>

            <div class="overflow-x-auto">
                <table id="membershipTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Tier</th>
                            <th>Loyalty Point</th>
                            <th>Expired</th>
                            <th>Free Entry</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="redeemModal" class="fixed inset-0 hidden bg-black/40 flex items-center justify-center">
        <div class="bg-white rounded p-6 w-80">
            <h3 class="font-semibold mb-3">Tukar Loyalty Point</h3>

            <div class="flex items-center justify-center gap-2 mb-4">
                <button onclick="minusQty()" class="px-3 py-1 bg-gray-200 rounded">-</button>
                <input type="number" id="redeemQty"
                    onkeyup="validateQty()"
                    class="w-16 text-center border rounded"
                    value="1" min="1">
                <button onclick="plusQty()" class="px-3 py-1 bg-gray-200 rounded">+</button>
            </div>

            <div class="flex justify-end gap-2">
                <button onclick="closeRedeemModal()" class="text-gray-500">Batal</button>
                <button onclick="submitRedeem()" class="bg-green-600 text-white px-3 py-1 rounded">
                    Tukar
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#membershipTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('membership.index') }}",
            order: [[1, 'asc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center' },
                { targets: 2, type: 'string' },
                { targets: 3, type: 'string' },
                { targets: 4, type: 'string' },
                { targets: 5, type : 'string' },
                { targets: 6, width: '80px', className: 'text-center' },
                { targets: 7, width: '150px', className: 'text-center' },
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'nama_lengkap', name: 'nama_lengkap' },
                { data: 'tier', name: 'tier' },
                { data: 'loyalty_point', name: 'loyalty_point' },
                { data: 'expired', name: 'expired' },
                { data: 'free_entry', name: 'free_entry' },
                { data: 'aktif', name: 'aktif' },
                { data: 'aksi', orderable:false, searchable:false },
            ]
        });
    });

    let membershipId = null
    let maxPoint = 0
    const POINT_PER_ENTRY = 10

    function openRedeemModal(id, point) {
    if (point < POINT_PER_ENTRY) {
        alert('Loyalty point tidak mencukupi')
        return
    }   
        membershipId = id
        maxPoint = point
        document.getElementById('redeemQty').value = 1
        document.getElementById('redeemModal').classList.remove('hidden')
    }

    function closeRedeemModal() {
        document.getElementById('redeemModal').classList.add('hidden')
    }

    function plusQty() {
        let input = document.getElementById('redeemQty')
        let maxQty = Math.floor(maxPoint / POINT_PER_ENTRY)
        if (parseInt(input.value) < maxQty) {
            input.value++
        }
    }

    function minusQty() {
        let input = document.getElementById('redeemQty')
        if (parseInt(input.value) > 1) {
            input.value--
        }
    }

    function validateQty() {
        let input = document.getElementById('redeemQty')
        let maxQty = Math.floor(maxPoint / POINT_PER_ENTRY)

        if (input.value < 1) input.value = 1
        if (input.value > maxQty) input.value = maxQty
    }

    function submitRedeem() {
        fetch(`/membership/${membershipId}/redeem-point`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                qty: document.getElementById('redeemQty').value
            })
        })
        .then(res => {
            if (!res.ok) throw res
            return res.json()
        })
        .then(() => {
            closeRedeemModal()
            $('#membershipTable').DataTable().ajax.reload(null, false)
        })
    }

    let kendaraanTable = null
    let currentMembershipId = null

    function openKendaraanModal(id) {
        currentMembershipId = id
        document.getElementById('kendaraanModal').classList.remove('hidden')

        if (kendaraanTable) {
            kendaraanTable.ajax.url(`/membership/${id}/kendaraan`).load()
            return
        }

        kendaraanTable = $('#kendaraanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: `/membership/${id}/kendaraan`,
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'plat_nomor' },
                { data: 'tipe_kendaraan' },
                { data: 'warna' },
                { data: 'pemilik' },
            ]
        })
    }

    function closeKendaraanModal() {
        document.getElementById('kendaraanModal').classList.add('hidden')
    }
    </script>
    @endpush
</x-app-layout>
@include('membership._modal_kendaraan')