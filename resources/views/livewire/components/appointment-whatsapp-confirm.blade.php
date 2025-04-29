<div>
    @if ($error == '')
        <form wire:submit.prevent="submit">
            @csrf
            <flux:textarea wire:model="whatsappMessage" resize="none" />
            <flux:text class="my-6">{{ __('appointment.modal_footer_hint') }}</flux:text>
            <div class="flex justify-end">
                @if ($type == 'approve')
                <flux:button type="submit" variant="primary">{{ __('appointment.approve_title') }}</flux:button>
                @else
                <flux:button type="submit" variant="danger">{{ __('appointment.delete') }}</flux:button>
                @endif
            </div>
        </form>
    @else
        <p class="text-red-500">{{ $error }}</p>
        <div class="flex justify-end">
            <flux:button onclick="window.location.reload()">{{ __('Refresh') }}</flux:button>
        </div>
    @endif
</div>

<script>
    window.addEventListener('whatsapp:send', event => {
        const number = event.detail[0].number;
        const message = encodeURIComponent(event.detail[0].message);
        const url = `http://wa.me/${number}?text=${message}`;
        window.open(url, '_blank');
        window.Flux.modal().close();
        window.location.reload();
    })
</script>