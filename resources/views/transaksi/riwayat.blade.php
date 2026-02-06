<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        /* HEADER */
        #riwayatTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        /* BODY */
        #riwayatTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        /* ROW HOVER */
        #riwayatTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        /* HILANGKAN style bawaan datatables */
        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <div class="overflow-x-auto">
                <table id="riwayatTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Plat</th>
                            <th>Tipe</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#riwayatTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaksi.riwayat') }}",
            order: [[1, 'desc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center'},
                { targets: 3, type: 'string'},
                { targets: 4, type: 'string'},
                { targets: 5, width: '100px'},
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'plat', name: 'plat' },
                { data: 'tipe', name: 'tipe' },
                { data: 'durasi', name: 'durasi' },
                { data: 'biaya_total', name: 'biaya_total' },
                { data: 'aksi', orderable:false, searchable:false },
            ]
        });
    });
    </script>
    @endpush
</x-app-layout>
