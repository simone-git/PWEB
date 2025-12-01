// public/assets/js/login.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');

    if (!form) {
        return;
    }

    form.addEventListener('submit', (event) => {
        const username = document.getElementById('username');
        const password = document.getElementById('password');

        // Esempio di piccola validazione lato client
        if (!username.value.trim() || !password.value.trim()) {
            event.preventDefault();
            alert('Compila tutti i campi prima di continuare.');
        }
    });
});
