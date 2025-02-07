import './bootstrap';

import '../css/app.css'; 

import Alpine from 'alpinejs';

import feather from 'feather-icons';

document.addEventListener("DOMContentLoaded", () => {
    feather.replace();
});


window.Alpine = Alpine;

Alpine.start();
