<div class="absolute z-100 top-4 right-4 left-4 md:left-auto max-w-xl">
    @if ($showNotification)
        @if ($variant == "errors")
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-red-400 border border-red-400" role="alert">
        @else
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-green-400 border border-green-400" role="alert">
        @endif
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="me-2">
                <span class="font-medium">{{ $message }}</span>
            </div>
            <button type="button" id="close-notif" wire:click="closeNotification"
                @if ($variant == "errors")
                    class="ms-auto -mx-1.5 -my-1.5 bg-gray-50 text-red-800 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                @else
                    class="ms-auto -mx-1.5 -my-1.5 bg-gray-50 text-green-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                @endif
                data-dismiss-target="#alert-1" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <script>
            setTimeout(() => { document.getElementById('close-notif').click() }, 2000);
        </script>
    @endif
</div>