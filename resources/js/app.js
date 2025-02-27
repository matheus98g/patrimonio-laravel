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


// resources/js/app.js
document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // Verifica o modo atual ao carregar
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && htmlElement.classList.contains('dark'))) {
        htmlElement.classList.add('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    } else {
        htmlElement.classList.remove('dark');
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
    }

    // Alterna o tema ao clicar
    toggleButton.addEventListener('click', () => {
        if (htmlElement.classList.contains('dark')) {
            htmlElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        } else {
            htmlElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        }

        // // Opcional: Salvar a preferência no backend via AJAX
        // fetch('/toggle-theme', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        //     },
        //     body: JSON.stringify({ dark_mode: htmlElement.classList.contains('dark') })
        // });
    });
});