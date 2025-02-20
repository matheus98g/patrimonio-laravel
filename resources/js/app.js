import './bootstrap';

import '../css/app.css'; 

import Alpine from 'alpinejs';

import collapse from '@alpinejs/collapse'
 
Alpine.plugin(collapse)

import feather from 'feather-icons';

document.addEventListener("DOMContentLoaded", () => {
    feather.replace();
});


window.Alpine = Alpine;

Alpine.start();

