import { postJson } from "./app.js";


document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const password2 = document.getElementById('password2');

        if (!username.value.trim() || !password.value.trim() || !password2.value.trim()) {
            alert('Compila tutti i campi prima di continuare.');
            return;
        }

        if(password.value != password2.value) {
            alert('Le password non coincidono');
            return;
        }

        postJson("/register", {
            usr: username.value,
            pwd: password.value
        }).then(data => {
            if(data.redirect !== undefined)
                document.location.href = data.redirect;
        }).catch(error => {
            alert(error);
        });
    });
});
