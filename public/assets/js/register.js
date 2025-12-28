document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const password2 = document.getElementById('password2');

        if(password.value != password2.value) {
            alert('Le password non coincidono');
            return;
        }

        if (!email.value.trim() || !password.value.trim()) {
            alert('Compila tutti i campi prima di continuare.');
            return;
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(body)
        });
    });
});



