<style>
    /* Sembunyikan panah di layar kecil */
    @media (max-width: 767px) {
        .fa-arrow-right {
            display: none !important;
        }
    }
</style>
<x-layouts.app>
    <div
    class="flex w-full flex-1 flex-col rounded-2xl px-8 py-6 bg-gradient-to-br from-blue-100 via-blue-100 to-blue-200 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900 shadow-xl">

    <div class="flex justify-between items-start">
        {{-- Breadcrumbs kiri --}}
        <x-bread-crumbs />

        {{-- Logo kanan --}}
        <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo" class="w-18 sm:w-25 !important h-auto object-contain"
        />
    </div>

    {{-- Title --}}
    <h2 class="font-semibold text-center md:text-start text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
        {{ __('dashboard.welcome') }} 
        <span class="text-rose-600 dark:text-fuchsia-300 font-bold">
            {{ Auth::user()->name }}
        </span>!
    </h2>
    {{-- / Title --}}

    <p class="text-sm text-rose-600 dark:text-rose-300">
        Jika tampilan terlihat berantakan, silakan lakukan <strong>zoom out</strong> pada browser Anda (Ctrl +
        Scroll atau Ctrl + -).
    </p>
</div>



    <div class="flex w-full flex-1 flex-col gap-6 rounded-xl p-6 bg-gray-100 dark:bg-gray-900 mt-2">
        <div class="grid gap-2 md:gap-4 grid-cols-2 md:grid-cols-4 text-center">
            <!-- Total Dokter -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-blue-100 dark:bg-slate-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-user-md text-3xl mb-2 text-blue-500"></i>
                <h2 class="text-sm font-semibold">Total Dokter</h2>
                <p class="text-1xl font-bold">{{ $totalDoctors }}</p>
                <span
                    class="text-sm sm:text-sm font-medium text-green-600 bg-green-200 dark:text-green-900 px-4 rounded-full shadow-sm dark:shadow-md">
                    +{{ $newDoctorsToday }} hari ini
                </span>

            </div>

            <!-- Total Pasien -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-green-100 dark:bg-slate-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-user-injured text-3xl mb-2 text-green-500"></i>
                <h2 class="text-sm font-semibold">Total Pasien</h2>
                <p class="text-1xl font-bold">{{ $totalPatients }}</p>
                <span
                    class="text-sm sm:text-sm font-medium text-green-600 bg-green-200 dark:text-green-900 px-4 rounded-full shadow-sm dark:shadow-md">+{{ $newPatientsToday }}
                    hari ini</span>
            </div>

            <!-- Total Rekam Medis -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-yellow-100 dark:bg-slate-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-file-medical text-3xl mb-2 text-yellow-500"></i>
                <h2 class="text-sm font-semibold">Total Rekam Medis</h2>
                <p class="text-1xl font-bold">{{ $totalMedicalRecords }}</p>
                <span
                    class="text-sm sm:text-sm font-medium text-green-600 bg-green-200 dark:text-green-900 px-4 rounded-full shadow-sm dark:shadow-md">+{{ $newMedicalRecordsToday }}
                    hari ini</span>
            </div>

            <!-- Stok Obat -->
            <div
                class="flex flex-col items-center p-5 rounded-xl bg-red-100 dark:bg-slate-800 text-gray-900 dark:text-white shadow-md hover:shadow-lg transition">
                <i class="fas fa-pills text-3xl mb-2 text-red-500"></i>
                <h2 class="text-sm font-semibold">Total Jenis Obat</h2>
                <p class="text-1xl font-bold">{{ $totalMedicineStock }}</p>
                <span
                    class="text-sm sm:text-sm font-medium text-green-600 bg-green-200 dark:text-green-900 px-4 rounded-full shadow-sm dark:shadow-md">+{{ $newMedicineStockToday }}
                    hari ini</span>
            </div>
        </div>
        <div
            class="w-full bg-yellow-100 dark:bg-yellow-800 text-sm text-yellow-900 dark:text-yellow-100 p-4 rounded-lg shadow-md opacity-70">
            <i class="fas fa-info-circle mr-2"></i>
            Jika grafik tidak muncul, silakan <strong class="cursor-pointer hover:underline" onclick="window.location.reload()">refresh halaman</strong> untuk memuat ulang data.
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Grafik Area Statistik -->
            <div
                class="relative overflow-hidden rounded-xl border border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-gray-800 shadow-md">

                <!-- Header + Dropdown -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-2">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Visitor Rekam Medis</h2>
                    <div>
                        <label for="rangeSelector" class="mr-2 font-medium text-gray-700 dark:text-gray-200">Rentang
                            Waktu:</label>
                        <select id="rangeSelector"
                            class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm">
                            <option value="days" {{ request('range') == 'days' ? 'selected' : '' }}>7 Hari</option>
                            <option value="weeks" {{ request('range') == 'weeks' ? 'selected' : '' }}>7 Minggu
                            </option>
                            <option value="months"
                                {{ request('range') == 'months' || request('range') === null ? 'selected' : '' }}>7
                                Bulan</option>
                            <option value="years" {{ request('range') == 'years' ? 'selected' : '' }}>7 Tahun</option>
                        </select>
                    </div>
                </div>

                <canvas id="areaChart" class="w-full max-h-[300px]"></canvas>
            </div>

            <!-- Grafik Bar Pasien -->
            <div
                class="relative overflow-hidden rounded-xl border border-neutral-300 dark:border-neutral-700 p-6 bg-white dark:bg-gray-800 shadow-md">
                <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Statistik Data Pasien</h2>
                <canvas id="dashboardChart" class="w-full max-h-[300px]"></canvas>
                <p class="text-sm text-blue-600 dark:text-blue-300 mt-2 text-center">
                    <i class="fas fa-info-circle mr-1"></i> Keterangan: Sumbu X menunjukkan rentang umur pasien
                </p>
            </div>
        </div>

        <div
            class="p-6 md:p-6 rounded-xl border border-blue-300 bg-blue-50 dark:border-blue-600 dark:bg-blue-900 dark:text-blue-100 opacity-70">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i> Alur Penggunaan Sistem Rekam Medis
            </h3>
            <div
                class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 text-sm text-blue-900 dark:text-blue-100">
                <div class="flex items-center space-x-2">
                    <div
                        class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center font-bold">
                        1</div>
                    <span>Masuk ke menu <strong>Dokter</strong>, lalu isi data dokter secara lengkap</span>
                </div>
                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center space-x-2">
                    <div
                        class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center font-bold">
                        2</div>
                    <span>Masuk ke menu <strong>Pasien</strong>, lalu tambahkan data pasien</span>
                </div>
                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center space-x-2">
                    <div
                        class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center font-bold">
                        3</div>
                    <span>Masuk ke menu <strong>Obat</strong> dan tambahkan data obat</span>
                </div>
                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center space-x-2">
                    <div
                        class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center font-bold">
                        4</div>
                    <span>Masuk ke <strong>Rekam Medis</strong>, lalu isi dan simpan rekam medis</span>
                </div>
            </div>
        </div>
    </div>

    <script>    
        function loadChart() {
            const isDarkMode = document.documentElement.classList.contains("dark");
    
            const textColor = isDarkMode ? "#e5e7eb" : "#333";
            const gridColor = isDarkMode ? "#374151" : "#ddd";
    
            const lineBgColor = isDarkMode ? "rgba(168, 85, 247, 0.2)" : "rgba(54, 162, 235, 0.2)";
            const lineBorderColor = isDarkMode ? "rgba(168, 85, 247, 1)" : "rgba(54, 162, 235, 1)";
            
            const ctxBar = document.getElementById("dashboardChart")?.getContext("2d");
            if (ctxBar) {
                if (window.barChartInstance) window.barChartInstance.destroy();
                window.barChartInstance = new Chart(ctxBar, {
                    type: "bar",
                    data: {
                        labels: {!! json_encode($rangeLabels) !!},
                        datasets: [
                            {
                                label: "Laki-laki",
                                data: {!! json_encode($maleCounts) !!},
                                backgroundColor: lineBorderColor,
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
                                ticks: { color: textColor },
                                grid: { color: gridColor },
                            },
                            x: {
                                ticks: { color: textColor },
                                grid: { color: gridColor },
                            },
                        },
                    },
                });
            }
    
            const ctxArea = document.getElementById("areaChart")?.getContext("2d");
            if(ctxArea) {
                if (window.lineChartInstance) window.lineChartInstance.destroy();
                window.lineChartInstance = new Chart(ctxArea, {
                    type: "line",
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: "Jumlah Rekam Medis",
                            data: @json($chartData),
                            backgroundColor: lineBgColor,
                            borderColor: lineBorderColor,
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
                                ticks: { color: textColor },
                                grid: { color: gridColor },
                            },
                            x: {
                                ticks: { color: textColor },
                                grid: { color: gridColor },
                            },
                        },
                    },
                });
            }
        }

        // Event listener dropdown
        document.getElementById("rangeSelector")?.addEventListener("change", function() {
            const selectedRange = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set("range", selectedRange);
            window.location.href = url.toString(); // redirect dengan parameter baru
        });
    
        // Observer untuk mendeteksi perubahan mode gelap/terang
        if (window.darkModeObserver) window.darkModeObserver.disconnect();
        window.darkModeObserver = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                if (mutation.attributeName === "class") {
                    loadChart(); // update chart saat mode berubah
                }
            }
        });
    
        window.darkModeObserver.observe(document.documentElement, { attributes: true });
    
        // Panggil saat pertama kali
        window.addEventListener("DOMContentLoaded", () => {
            if (window.location.pathname === '/dashboard') {
                loadChart();
            }
        });
    </script>
    
</x-layouts.app>
