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
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        {{ $slot }}
        @fluxScripts
    </body>
</html>
