<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-cover bg-center bg-no-repeat min-h-screen text-white"
    style="background-image: url('/assets/img/bg-batikdark.jpg');">

    <!-- Header Logo -->
    <header class="absolute top-4 left-4 z-10">
        <img src="/assets/img/logo_hp.png" alt="Logo Apotek F21" class="h-16 w-auto" />
    </header>

    <!-- Konten Utama -->
    <div
        class="min-h-screen flex flex-col md:flex-row items-center justify-center px-6 py-16 bg-black bg-opacity-10 space-y-10 md:space-y-0">

        <!-- Google Maps Embed -->
        <div class="md:w-1/2 flex justify-center">
            <!-- Lokasi Peta -->
            <div
                class="w-[95%] max-w-[650px] aspect-[4/3] bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-violet-700 text-white px-6 py-3 font-semibold flex items-center gap-2">
                    <i class="fas fa-map-marked-alt"></i>
                    Lokasi Apotek F21
                </div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.3863648593597!2d110.4061231!3d-7.7487800999999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a597468b3dfdb%3A0xfdc327e70bd53f02!2sApotek%20F-21%20Minomartani!5e0!3m2!1sen!2sid!4v1749438707445!5m2!1sen!2sid"
                    class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Kontak Info -->
        <div class="md:w-1/2 max-w-xl">
            <h1 class="text-4xl font-bold mb-4 text-white">Hubungi Kami</h1>
            <p class="text-lg text-gray-300 mb-6">
                Apotek F21 Minomartani siap membantu Anda. Silakan hubungi kami melalui informasi di bawah ini.
            </p>

            <div class="space-y-3 text-gray-200 text-base mb-6">
                <p><strong><i class="fas fa-home mr-2"></i>Alamat:</strong> Jl. Raya Minomartani No.21, Sleman,
                    Yogyakarta</p>
                <p><strong><i class="fas fa-envelope mr-2"></i>Email:</strong> info@apotekf21.com</p>
                <p><strong><i class="fas fa-phone mr-2"></i>Telepon:</strong> (0274) 123-456</p>
                <p><strong><i class="fas fa-clock mr-2"></i>Jam Operasional:</strong> Senin - Sabtu, 08.00 - 20.00 WIB
                </p>
            </div>


            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/" wire:navigate
                    class="bg-white text-gray-800 hover:bg-gray-100 px-6 py-3 rounded-xl text-center transition w-full sm:w-auto font-medium shadow-md">
                    ← Kembali ke Beranda
                </a>
                <a href="/daftar" wire:navigate
                    class="bg-violet-700 hover:bg-violet-800 text-white px-6 py-3 rounded-xl text-center transition w-full sm:w-auto font-medium shadow-md">
                    Buat Janji Temu
                </a>
            </div>

            <!-- Sosial Media -->
            <div class="flex gap-5 mt-6 text-2xl text-white">
                <a href="#" class="hover:text-green-400 transition" aria-label="WhatsApp"><i
                        class="fab fa-whatsapp"></i></a>
                <a href="#" class="hover:text-pink-400 transition" aria-label="Instagram"><i
                        class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-blue-400 transition" aria-label="Facebook"><i
                        class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>

    @fluxScripts
</body>

</html>
