<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    <!-- DotLottie Player -->
        <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <!-- PWA -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>

<body class="bg-cover bg-center bg-no-repeat min-h-screen text-white"
    style="background-image: url('/assets/img/bg-batikdark.jpg');">

    <!-- Header: Logo -->
    <header class="absolute top-4 left-4">
    <img src="/assets/img/logo_hp.png" alt="Logo Apotek F21" class="w-auto h-12 md:h-16">
</header>


    <!-- Main Content -->
    <div class="min-h-screen flex flex-col md:flex-row items-center justify-center px-6 py-12">

        <!-- Left: Lottie Animation -->
        <div class="md:w-1/2 flex justify-center mb-10 md:mb-0">
            <dotlottie-player src="https://lottie.host/12ec311f-86e7-4bbb-9442-5ca4e5cb696d/1TfLHc21wB.lottie"
                background="transparent" speed="1" class="w-72 h-72 sm:w-96 sm:h-96 md:w-[500px] md:h-[500px]" loop
                autoplay>
            </dotlottie-player>

        </div>

        <!-- Right: Text & Buttons -->
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 text-custom-50">Layanan Janji Temu Rekam Medis</h1>
            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                Apotek F21 Minomartani kini menyediakan layanan janji temu untuk pengelolaan data rekam medis yang lebih
                cepat, mudah, dan efisien.
                Buat janji temu Anda sekarang untuk pelayanan kesehatan yang lebih baik.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="/daftar" wire:navigate
                    class="bg-[#6D28D9] hover:bg-[#5B21B6] text-white px-6 py-3 rounded-xl text-sm sm:text-base text-center transition">
                    Buat Janji Temu
                </a>
                <a href="/kontakami" wire:navigate
                    class="bg-white hover:bg-gray-100 text-gray-800 px-6 py-3 rounded-xl text-sm sm:text-base text-center transition">Hubungi
                    Kami</a>
            </div>
        </div>

    </div>

    @fluxScripts
        <script src="{{ asset('/sw.js') }}"></script>
    <script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        }
        );
    } else {
        console.error("Service workers are not supported.");
    }
    </script>
</body>

</html>
