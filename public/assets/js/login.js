import { postJson } from "./app.js";


document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const username = document.getElementById('username');
        const password = document.getElementById('password');
        
        if (!username.value.trim() || !password.value.trim()) {
            alert('Compila tutti i campi prima di continuare.');
            return;
        }

        postJson("/login", {
            usr: username.value,
            pwd: password.value
        }).then(data => {
            console.log(data);
            if(data.redirect !== undefined)
                document.location.href = data.redirect;
        }).catch(error => {
            alert(error);
        });
    });
});
