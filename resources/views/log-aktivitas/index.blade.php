<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="overflow-x-auto">
                        <table id="logTable" class="min-w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-100 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3">Waktu</th>
                                    <th class="px-4 py-3">Dibuat Oleh</th>
                                    <th class="px-4 py-3">IP</th>
                                    <th class="px-4 py-3">User Agent</th>
                                    <th class="px-4 py-3">Method</th>
                                    <th class="px-4 py-3">Aktivitas</th>
                                    <th class="px-4 py-3 text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- Modal -->
                        <div id="logModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white w-2/3 rounded-lg shadow-lg p-6 relative">
                                <h3 class="text-lg font-semibold mb-4">Detail Log Aktivitas</h3>

                                <div class="space-y-3 text-sm">
                                    <div>
                                        <strong>Aktivitas:</strong>
                                        <div id="modalActivity" class="mt-1 text-gray-700"></div>
                                    </div>

                                    <div>
                                        <strong>User Agent:</strong>
                                        <div id="modalUserAgent" class="mt-1 text-gray-700 break-words"></div>
                                    </div>

                                    <div>
                                        <strong>Before:</strong>
                                        <pre id="modalBefore" class="bg-gray-100 p-2 rounded text-xs overflow-x-auto"></pre>
                                    </div>

                                    <div>
                                        <strong>After:</strong>
                                        <pre id="modalAfter" class="bg-gray-100 p-2 rounded text-xs overflow-x-auto"></pre>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <button id="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#logTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('log-aktivitas.index') }}",
        order: [[0, 'desc']],
        autoWidth: false,
        columnDefs: [
            { targets: 0, width: '160px' },
            { targets: 2, width: '130px' },
            { targets: 4, width: '120px' },
        ],
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'user', name: 'user.name' },
            { data: 'ip', name: 'ip' },
            {
                data: 'user_agent',
                name: 'user_agent',
                render: function(data) {
                    if (!data) return '-';
                    return data.length > 40 
                        ? data.substr(0, 40) + '...' 
                        : data;
                }
            },
            { data: 'method', name: 'method' },
            {
                data: 'activity',
                name: 'activity',
                render: function(data) {
                    return data.length > 60 
                        ? data.substr(0, 60) + '...' 
                        : data;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data) {
                    return `
                        <button 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs detail-btn"
                            data-before='${data.before ?? ""}'
                            data-after='${data.after ?? ""}'
                            data-activity='${data.activity}'
                            data-useragent='${data.user_agent}'
                        >
                            Detail
                        </button>
                    `;
                }
            }
        ]
    });

    // Handle modal open
    $(document).on('click', '.detail-btn', function () {

        let before = $(this).data('before');
        let after  = $(this).data('after');
        let activity = decodeURIComponent($(this).data('activity') || '');
        let userAgent = decodeURIComponent($(this).data('useragent') || '');

        // Kalau masih string JSON → parse
        try {
            if (typeof before === 'string') before = JSON.parse(before);
            if (typeof after === 'string') after = JSON.parse(after);
        } catch (e) {}

        // Tampilkan dengan format rapi
        $('#modalActivity').text(activity || '-');
        $('#modalUserAgent').text(userAgent || '-');
        $('#modalBefore').text(before ? JSON.stringify(before, null, 2) : '-');
        $('#modalAfter').text(after ? JSON.stringify(after, null, 2) : '-');

       $('#logModal').removeClass('hidden').addClass('flex');
    });

    // Close modal
    $('#closeModal').click(function () {
        $('#logModal').removeClass('flex').addClass('hidden');
    });
});
</script>

@endpush
</x-app-layout>

