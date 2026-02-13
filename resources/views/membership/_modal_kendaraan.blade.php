<div id="kendaraanModal"
     class="fixed inset-0 hidden bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-lg p-6 w-[700px]">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">🚗 Data Kendaraan Membership</h3>
            <button onclick="closeKendaraanModal()" class="text-gray-500">✕</button>
        </div>

        <table id="kendaraanTable" class="w-full text-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Tipe</th>
                    <th>Warna</th>
                    <th>Pemilik</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
