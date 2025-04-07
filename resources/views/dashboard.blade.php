<x-layouts.app>
    <div class="flex w-full flex-1 flex-col  rounded-xl p-6 bg-gray-100 dark:bg-gray-900">
        Selamat datang di Dashboard Klinik F-21 Minomartani
    </div>
    <div class="flex w-full flex-1 flex-col gap-6 rounded-xl p-6 bg-gray-100 dark:bg-gray-900 mt-2">
        <div class="grid gap-6 md:grid-cols-4">
            <!-- Total Dokter -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-blue-100 dark:bg-blue-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-user-md text-5xl mb-2 text-blue-500"></i>
                <h2 class="text-lg font-semibold">Total Dokter</h2>
                <p class="text-2xl font-bold">{{ $totalDoctors }}</p>
                <span class="text-sm text-green-500">+{{ $newDoctorsToday }} hari ini</span>
            </div>

            <!-- Total Pasien -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-green-100 dark:bg-green-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-user-injured text-5xl mb-2 text-green-500"></i>
                <h2 class="text-lg font-semibold">Total Pasien</h2>
                <p class="text-2xl font-bold">{{ $totalPatients }}</p>
                <span class="text-sm text-green-500">+{{ $newPatientsToday }} hari ini</span>
            </div>

            <!-- Total Rekam Medis -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-yellow-100 dark:bg-yellow-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-file-medical text-5xl mb-2 text-yellow-500"></i>
                <h2 class="text-lg font-semibold">Total Rekam Medis</h2>
                <p class="text-2xl font-bold">{{ $totalMedicalRecords }}</p>
                <span class="text-sm text-green-500">+{{ $newMedicalRecordsToday }} hari ini</span>
            </div>

            <!-- Stok Obat -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-red-100 dark:bg-red-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-pills text-5xl mb-2 text-red-500"></i>
                <h2 class="text-lg font-semibold">Total Stok Obat</h2>
                <p class="text-2xl font-bold">{{ $totalMedicineStock }}</p>
                <span class="text-sm text-green-500">+{{ $newMedicineStockToday }} hari ini</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Grafik Area Statistik -->
            <div
                class="relative overflow-hidden rounded-xl border border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-gray-800 shadow-md">
                <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-gray-100">Visitor Rekam Medis</h2>
                <canvas id="areaChart" class="w-full max-h-[300px]"></canvas>
            </div>

            <!-- Grafik Bar Pasien -->
            <div
                class="relative overflow-hidden rounded-xl border border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-gray-800 shadow-md">
                <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-gray-100">Statistik Data Pasien
                </h2>
                <canvas id="dashboardChart" class="w-full max-h-[250px]"></canvas>
            </div>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Instruksi -->
            <div
                class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-neutral-300 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <i class="fas fa-book-open text-2xl mr-2 text-blue-500"></i> Instruksi Penggunaan
                </h2>
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    <div>
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-md text-blue-500 mr-2"></i> Isi Data Dokter
                        </h3>
                        <ul class="list-disc list-inside ml-4 text-sm">
                            <li>Masuk ke menu "Dokter" pada sidebar.</li>
                            <li>Klik tombol "Tambah Dokter".</li>
                            <li>Isi formulir dengan informasi lengkap dokter.</li>
                            <li>Klik tombol "Simpan" untuk menyimpan data.</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-pills text-green-500 mr-2"></i> Isi Data Obat
                        </h3>
                        <ul class="list-disc list-inside ml-4 text-sm">
                            <li>Masuk ke menu "Obat".</li>
                            <li>Klik tombol "Tambah Obat".</li>
                            <li>Isi formulir dengan detail obat, termasuk stok dan tanggal kadaluarsa.</li>
                            <li>Klik "Simpan" untuk menambahkan obat ke sistem.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div
                class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-neutral-300 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <i class="fas fa-file-medical text-2xl mr-2 text-yellow-500"></i> Pengelolaan Rekam Medis
                </h2>
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    <div>
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user text-red-500 mr-2"></i> Isi Data Pasien
                        </h3>
                        <ul class="list-disc list-inside ml-4 text-sm">
                            <li>Masuk ke menu "Pasien".</li>
                            <li>Klik tombol "Tambah Pasien".</li>
                            <li>Masukkan informasi pasien, termasuk riwayat medis.</li>
                            <li>Klik "Simpan" untuk menyimpan data pasien.</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-print text-purple-500 mr-2"></i> Cetak Rekam Medis
                        </h3>
                        <ul class="list-disc list-inside ml-4 text-sm">
                            <li>Masuk ke menu "Rekam Medis".</li>
                            <li>Pilih rekam medis yang ingin dicetak.</li>
                            <li>Klik ikon "Print" atau tombol "Cetak Rekam Medis".</li>
                            <li>Pastikan informasi sudah benar sebelum mencetak.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>





    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah mode gelap aktif
            const isDarkMode = document.documentElement.classList.contains("dark");

            // Warna teks dan grid disesuaikan dengan mode gelap
            const textColor = isDarkMode ? "#e5e7eb" : "#333";
            const gridColor = isDarkMode ? "#374151" : "#ddd";

            // Grafik Statistik Umur & Jenis Kelamin
    const ctxBar = document.getElementById("dashboardChart").getContext("2d");
            new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: {!! json_encode($rangeLabels) !!},
            datasets: [
                {
                    label: "Laki-laki",
                    data: {!! json_encode($maleCounts) !!},
                    backgroundColor: "#60a5fa",
                    borderRadius: 6,
                },
                {
                    label: "Perempuan",
                    data: {!! json_encode($femaleCounts) !!},
                    backgroundColor: "#f472b6",
                    borderRadius: 6,
                }
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: textColor,
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: textColor,
                    },
                    grid: {
                        color: gridColor,
                    },
                },
                x: {
                    ticks: {
                        color: textColor,
                    },
                    grid: {
                        color: gridColor,
                    },
                },
            },
        },
    });


            // Grafik Line (Tren Data)
            var ctxArea = document.getElementById("areaChart").getContext("2d");
            new Chart(ctxArea, {
                type: "line",
                data: {
                    labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
                    datasets: [{
                        label: "Jumlah Visitor",
                        data: [5, 10, 8, 15, 7, 12, 9], // Data contoh
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                            },
                            grid: {
                                color: gridColor,
                            },
                        },
                        x: {
                            ticks: {
                                color: textColor,
                            },
                            grid: {
                                color: gridColor,
                            },
                        },
                    },
                },
            });
        });
    </script>
</x-layouts.app>
