document.getElementById('loginForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() === '' || password.trim() === '') {
        alert('Por favor, completa todos los campos.');
        event.preventDefault(); // Evita el envío del formulario
    }

    // Puedes agregar más validaciones si lo deseas
});
