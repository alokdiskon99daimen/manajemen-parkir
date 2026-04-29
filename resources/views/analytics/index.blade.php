<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advanced Analytics') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================= FILTER ================= --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <form method="GET" class="flex flex-wrap gap-4 items-end">

                    <div>
                        <label class="text-sm">Dari</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date', $start->format('Y-m-d')) }}"
                               class="border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm">Sampai</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date', $end->format('Y-m-d')) }}"
                               class="border rounded px-3 py-2">
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Filter
                    </button>

                    <a href="{{ route('analytics.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded">
                        Reset
                    </a>

                </form>
            </div>

            {{-- ================= KPI CARDS ================= --}}
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h4 class="text-sm text-gray-500">Total Revenue</h4>
                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($totalRevenue,0,',','.') }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h4 class="text-sm text-gray-500">Total Transaksi</h4>
                    <p class="text-2xl font-bold">
                        {{ $totalTransaksi }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h4 class="text-sm text-gray-500">Rata-rata Ticket</h4>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp {{ number_format($avgTicket,0,',','.') }}
                    </p>
                </div>
            </div>

            {{-- ================= CHARTS ================= --}}
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Revenue -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold mb-4">Revenue Trend</h3>
                    <canvas id="revenueChart"></canvas>
                </div>

                <!-- Peak Hour -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold mb-4">Peak Hour</h3>
                    <canvas id="peakChart"></canvas>
                </div>

            </div>

            <!-- Payment Method -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Payment Method Breakdown</h3>
                <canvas id="paymentChart"></canvas>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Member vs Non-Member Revenue</h3>
                <canvas id="memberChart"></canvas>
            </div>

        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ================= REVENUE LINE =================
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: @json($revenueHarian->pluck('tanggal')),
        datasets: [{
            label: 'Revenue (Rp)',
            data: @json($revenueHarian->pluck('total_revenue')),
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Total Revenue (Rupiah)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});


// ================= PEAK HOUR BAR =================
new Chart(document.getElementById('peakChart'), {
    type: 'bar',
    data: {
        labels: @json($peakHour->pluck('jam')),
        datasets: [{
            label: 'Jumlah Transaksi',
            data: @json($peakHour->pluck('total_transaksi')),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Jam'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Total Transaksi'
                }
            }
        }
    }
});


// ================= PAYMENT PIE =================
new Chart(document.getElementById('paymentChart'), {
    type: 'pie',
    data: {
        labels: @json($paymentAnalysis->pluck('metode')),
        datasets: [{
            data: @json($paymentAnalysis->pluck('revenue'))
        }]
    },
    options: {
        responsive: true
    }
});

// ================= MEMBER VS NON MEMBER =================
new Chart(document.getElementById('memberChart'), {
    type: 'bar',
    data: {
        labels: @json($memberRevenue->pluck('tipe')),
        datasets: [{
            label: 'Total Revenue (Rp)',
            data: @json($memberRevenue->pluck('total')),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Tipe Pelanggan'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Total Revenue (Rupiah)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endpush
</x-app-layout>