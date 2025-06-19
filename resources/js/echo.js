import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

try {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true
    });
} catch(error) {
    // do nothing
}

if (window.Echo && window.x_layout === 'Dashboard') { // window.x_layout ter setup di sidebar.blade.php
    window.Echo.private(`new-appointment`)
        .listen('.notification.created', (e) => {
            console.log('Private notification received: ', e);
        });
}
