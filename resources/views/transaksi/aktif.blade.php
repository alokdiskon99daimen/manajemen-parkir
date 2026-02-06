<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Aktif
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        /* HEADER */
        #aktifTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        /* BODY */
        #aktifTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        /* ROW HOVER */
        #aktifTable.dataTable tbody tr:hover {
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
                <table id="aktifTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Plat</th>
                            <th>Tipe</th>
                            <th>Area</th>
                            <th>Waktu Masuk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#aktifTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaksi.aktif') }}",
            order: [[4, 'desc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center' },
                { targets: 5, className: 'text-center' },
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'plat', name: 'plat' },
                { data: 'tipe', name: 'tipe' },
                { data: 'area', name: 'area' },
                { data: 'waktu_masuk', name: 'waktu_masuk' },
                { data: 'status_badge', orderable:false, searchable:false },
            ]
        });
    });
    </script>
    @endpush
</x-app-layout>
