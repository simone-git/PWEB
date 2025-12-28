document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', (event) => {
        const username = document.getElementById('username');
        const password = document.getElementById('password');

        if (!username.value.trim() || !password.value.trim()) {
            event.preventDefault();
            alert('Compila tutti i campi prima di continuare.');
        }
    });
});
