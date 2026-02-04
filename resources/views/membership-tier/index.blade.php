<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Membership Tier') }}
        </h2>
    </x-slot>

    <style>
        #tarifTable.dataTable thead th {
            @apply text-sm font-semibold text-gray-700 bg-gray-50 border-b border-gray-200;
            padding: 12px 10px;
        }

        #tarifTable.dataTable tbody td {
            @apply text-sm text-gray-700 border-b border-gray-100;
            padding: 10px;
        }

        #tarifTable.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('membership-tier.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Tier
            </a>

            <div class="overflow-x-auto">
                <table id="tarifTable" class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th>No</th>
                            <th>Tier</th>
                            <th>Harga / Bulan</th>
                            <th>Diskon (%)</th>
                            <th>Free Entry</th>
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
        ajax: "{{ route('membership-tier.index') }}",
        order: [[1, 'asc']],
        autoWidth: false,
        columnDefs: [
            { targets: 0, width: '50px', className: 'text-center' },
            { targets: 3, type: 'string' },
            { targets: 4, type: 'string' },
            { targets: 5, width: '120px', className: 'text-center' },
        ],
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'tier', name: 'tier' },
            { data: 'harga', name: 'harga' },
            { data: 'diskon', name: 'diskon' },
            { data: 'free_entry', name: 'free_entry' },
            { data: 'aksi', orderable:false, searchable:false },
        ]
    });
});
</script>
@endpush
</x-app-layout>