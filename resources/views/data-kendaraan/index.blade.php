<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kendaraan') }}
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        #kendaraanTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        #kendaraanTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        #kendaraanTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('data-kendaraan.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Data Kendaraan
            </a>

            <div class="overflow-x-auto">
                <table id="kendaraanTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Tipe Kendaraan</th>
                            <th>Plat Nomor</th>
                            <th>Warna</th>
                            <th>Pemilik</th>
                            <th>Status</th>
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
        $('#kendaraanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-kendaraan.index') }}",
            order: [[1, 'asc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center' },
                { targets: 2, type: 'string' },
                { targets: 5, width: '100px', className: 'text-center' },
                { targets: 6, width: '120px', className: 'text-center' },
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'tipe_kendaraan', name: 'tipe_kendaraan' },
                { data: 'plat_nomor', name: 'plat_nomor' },
                { data: 'warna', name: 'warna' },
                { data: 'pemilik', name: 'pemilik' },
                { data: 'aktif', name: 'aktif' },
                { data: 'aksi', orderable:false, searchable:false },
            ]
        });
    });
    </script>
    @endpush
</x-app-layout>
