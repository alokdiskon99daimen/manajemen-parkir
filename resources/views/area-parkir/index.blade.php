<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Area Parkir') }}
        </h2>
    </x-slot>

    {{-- CSS khusus halaman --}}
    <style>
        #areaTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        #areaTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        #areaTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('area-parkir.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Area Parkir
            </a>

            <div class="overflow-x-auto">
                <table id="areaTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Nama Area</th>
                            <th>Lokasi</th>
                            <th>Kapasitas</th>
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
        $('#areaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('area-parkir.index') }}",
            order: [[1, 'asc']],
            autoWidth: false,
            columnDefs: [
                { targets: 0, width: '50px', className: 'text-center' },
                { targets: 3, type:'string'},
                { targets: 4, width: '120px', className: 'text-center' },
            ],
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'nama_area', name: 'nama_area' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'kapasitas', name: 'kapasitas' },
                { data: 'aksi', orderable:false, searchable:false },
            ]
        });
    });
    </script>
    @endpush
</x-app-layout>
