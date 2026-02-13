<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <!-- Bagian Kiri -->
            <div>
                <h2 class="font-semibold text-xl text-gray-800">
                    Advanced Analytics Dashboard
                </h2>
            </div>

            <!-- Bagian Kanan -->
            <div>
                <a href="{{ route('laporan.analytics.csv') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Export CSV
                </a>
                <button onclick="window.print()"
                    class="bg-red-600 text-white px-4 py-2 rounded">
                    Print / Save as PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-500">Revenue Member</p>
                <p class="text-xl font-semibold">
                    Rp {{ number_format($memberSummary['revenue_member']) }}
                </p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-500">Revenue Non Member</p>
                <p class="text-xl font-semibold">
                    Rp {{ number_format($memberSummary['revenue_non_member']) }}
                </p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-500">Transaksi Member</p>
                <p class="text-xl font-semibold">
                    {{ $memberSummary['total_member'] }}
                </p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-500">Peak Hour</p>
                <p class="text-xl font-semibold">
                    Jam {{ $peakHour->first()->jam ?? '-' }}
                </p>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded shadow">
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <canvas id="vehicleChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <canvas id="paymentChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const revenueData = {
            labels: {!! json_encode($revenueDaily->pluck('tanggal')) !!},
            datasets: [{
                label: 'Revenue Harian',
                data: {!! json_encode($revenueDaily->pluck('total')) !!}
            }]
        };

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: revenueData
        });

        new Chart(document.getElementById('vehicleChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($vehicleDist->pluck('label')) !!},
                datasets: [{
                    data: {!! json_encode($vehicleDist->pluck('total')) !!}
                }]
            }
        });

        new Chart(document.getElementById('paymentChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($paymentData->pluck('label')) !!},
                datasets: [{
                    data: {!! json_encode($paymentData->pluck('total_revenue')) !!}
                }]
            }
        });

        new Chart(document.getElementById('occupancyChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($occupancyRate->pluck('label')) !!},
                datasets: [{
                    label: 'Occupancy %',
                    data: {!! json_encode($occupancyRate->pluck('occupancy_rate')) !!}
                }]
            }
        });
    </script>
</x-app-layout>
