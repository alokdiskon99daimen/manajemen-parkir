<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Diskon') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
            <a href="{{ route('diskon.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Diskon
            </a>

            <div class="overflow-x-auto">
                <table id="diskonTable" class="w-full text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Diskon</th>
                            <th>Diskon (%)</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
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
    $('#diskonTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('diskon.index') }}",
        order: [[1, 'asc']],
        autoWidth: false,
        columnDefs: [
            { targets: 0, width: '50px', className: 'text-center' },
            { targets: 2, type: 'string' },
            { targets: 3, type: 'string' },
            { targets: 4, type: 'string' },
            { targets: 5, width: '80px', className: 'text-center' },
        ],
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'nama_diskon', name: 'nama_diskon' },
            { data: 'diskon', name: 'diskon' },
            { data: 'waktu_mulai', name: 'waktu_mulai' },
            { data: 'waktu_selesai', name: 'waktu_selesai' },
            { data: 'aksi', orderable:false, searchable:false },
        ]
    });
});
</script>
@endpush
</x-app-layout>
