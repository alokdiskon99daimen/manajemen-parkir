<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tarif') }}
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        /* HEADER */
        #tarifTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        /* BODY */
        #tarifTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        /* ROW HOVER */
        #tarifTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        /* HILANGKAN style bawaan datatables */
        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('tarif.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Tarif
            </a>

            <div class="overflow-x-auto">
                <table id="tarifTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Tipe Kendaraan</th>
                            <th>Durasi Mulai (Jam)</th>
                            <th>Tarif / Jam</th>
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
        $('#tarifTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tarif.index') }}",
            order: [[1, 'asc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center' },
                { targets: 2, className: 'text-left' },
                { targets: 3, className: 'text-left' },
                { targets: 4, width: '120px', className: 'text-center' },
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'tipe_kendaraan', name: 'tipe_kendaraan' },
                { data: 'durasi_mulai', name: 'durasi_mulai' },
                { data: 'tarif_per_jam', name: 'tarif_per_jam' },
                { data: 'aksi', orderable:false, searchable:false },
            ]
        });
    });
    </script>
    @endpush
</x-app-layout>