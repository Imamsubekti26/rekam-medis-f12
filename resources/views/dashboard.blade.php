<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <!-- Total Dokter -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-blue-500 text-white shadow-md">
                <div>
                    <h2 class="text-lg font-semibold">Total Dokter</h2>
                    <p class="text-2xl font-bold">{{ $totalDoctors }}</p>
                </div>
            </div>
            
            <!-- Total Pasien -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-green-500 text-white shadow-md">
                <div>
                    <h2 class="text-lg font-semibold">Total Pasien</h2>
                    <p class="text-2xl font-bold">{{ $totalPatients }}</p>
                </div>
            </div>
            
            <!-- Total Rekam Medis -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-yellow-500 text-white shadow-md">
                <div>
                    <h2 class="text-lg font-semibold">Total Rekam Medis</h2>
                    <p class="text-2xl font-bold">{{ $totalMedicalRecords }}</p>
                </div>
            </div>
            
            <!-- Stok Obat -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-red-500 text-white shadow-md">
                <div>
                    <h2 class="text-lg font-semibold">Total Stok Obat</h2>
                    <p class="text-2xl font-bold">{{ $totalMedicineStock }}</p>
                </div>
            </div>
        </div>
        
        <!-- Grafik atau Tabel Rekap Data -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h2 class="text-xl font-semibold mb-4">Statistik Data</h2>
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("dashboardChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Dokter", "Pasien", "Rekam Medis", "Stok Obat"],
                    datasets: [{
                        label: "Jumlah Data",
                        data: [{{ $totalDoctors }}, {{ $totalPatients }}, {{ $totalMedicalRecords }}, {{ $totalMedicineStock }}],
                        backgroundColor: ["#3b82f6", "#10b981", "#f59e0b", "#ef4444"],
                    }],
                },
            });
        });
    </script>
</x-layouts.app>
