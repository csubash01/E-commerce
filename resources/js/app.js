import './bootstrap';


import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

import 'preline';

import Swal from 'sweetalert2'

window.Swal = Swal

document.addEventListener('livewire:load', () => {
    window.HSStaticMethods.autoInit();
});

document.addEventListener('livewire:update', () => {
    window.HSStaticMethods.autoInit();
});

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});

