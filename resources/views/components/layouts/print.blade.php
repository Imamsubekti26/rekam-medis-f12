<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <script type="text/javascript">
        window.onafterprint = window.close;
        setTimeout(() => {
            window.print();
        }, 500)
    </script>
    <style>
        @media print {
            html {
                color-scheme: light;
                /* Force light mode */
                --tw-bg-opacity: 1;
                background-color: white !important;
            }

            body {
                background-color: white !important;
                color: black !important;
            }

            .dark * {
                background-color: white !important;
                color: black !important;
            }

            .ttd-dokter {
                text-align: right;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b">
    <main>
        <table style="width: 100%; border-bottom: 4px solid #000000;">
            <tr>
                <td style="width: 15%; border: none;">
                    <img src="{{ asset('/assets/img/logof21warna.png') }}" alt="Logo Apotek F-21 Minomartani"
                        style="width: 100px; height: auto; margin: 10px;">
                </td>
                <td style="text-align: center; border: none;">
                    <h2 style="margin: 0; font-size: 1.5rem; font-weight: 800;">Klinik F-21 Minomartani</h2>
                    <p style="margin: 0; font-size: 12px;">Jl. Contoh Alamat No. 456, Minomartani, Sleman, Yogyakarta
                    </p>
                    <p style="margin: 0; font-size: 12px;">Telepon: (0274) 7654321 | Email: info@apotekf21.com</p>
                </td>
                <td style="width: 15%; border: none;">
                </td>
            </tr>
        </table>
        <div class="dividers"></div>
        {{ $slot }}
    </main>
    {{-- bantu sesuakke ttd dokter e Mam hehe --}}
    <div class="ttd-dokter mt-8 flex justify-end mx-15">
        <div class="text-center text-sm leading-snug">
            <p>Dokter/Apoteker Penanggung Jawab</p>
            <img src="{{ asset('/assets/img/qr-code.png') }}" alt="Tanda Tangan Dokter"
                class="mx-auto" style="width: 100px; height: auto;">
            <p class="font-bold underline">dr. Nama Dokter/Apoteker</p>
            <p>SIP: 1234567890</p>
        </div>
    </div>    
    @fluxScripts
</body>

</html>
