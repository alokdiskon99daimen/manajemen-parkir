<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Transaksi Harian') }} 
                <span class="text-gray-500">({{ $tanggal->format('d M Y') }})</span>
            </h2>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 print:hidden">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Transaksi</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $data['total_transaksi'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Pendapatan</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($data['total_pendapatan'], 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Table Per Tipe Kendaraan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Per Tipe Kendaraan</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-2 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($data['by_tipe_kendaraan'] as $row)
                            <tr>
                                <td class="px-2 py-4 text-sm text-gray-900">{{ $row->tipe_kendaraan }}</td>
                                <td class="px-2 py-4 text-sm text-gray-900 text-right font-semibold">{{ $row->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Per Metode Pembayaran -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Per Metode Pembayaran</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-2 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-2 py-3 text-right text-xs font-medium text-gray-500 uppercase">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($data['by_metode_pembayaran'] as $row)
                            <tr>
                                <td class="px-2 py-4 text-sm text-gray-900">{{ $row->metode_pembayaran }}</td>
                                <td class="px-2 py-4 text-sm text-gray-900 text-right">{{ $row->total }}</td>
                                <td class="px-2 py-4 text-sm text-gray-900 text-right font-semibold">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            nav, .print\:hidden { display: none !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; }
            .shadow-sm { shadow: none !important; border: 1px solid #eee; }
        }
    </style>
</x-app-layout>
