document.getElementById('loginSubmit').addEventListener('click', async function (event) {
    event.preventDefault(); // Previene el envío del formulario.

    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value.trim();

    if (!email || !password) {
        alert('Por favor, completa todos los campos.');
        return;
    }

    try {
        const response = await fetch('?url=api&action=login', { // Cambia esta URL según la configuración de tu servidor.
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password }),
        });

        const result = await response.json();

        if (result.success) {
            const user = result.user;

            // Almacena los datos del usuario en sessionStorage.
            sessionStorage.setItem('id_user', user.id_user);
            sessionStorage.setItem('nombre', user.nombre);
            sessionStorage.setItem('admin', user.admin);

            alert(`Bienvenido, ${user.nombre}`);
            window.location.href = '?url=index'; // Cambia esto por la URL de redirección deseada.
        } else {
            alert(result.message || 'Credenciales incorrectas. Por favor, inténtalo de nuevo.');
        }
    } catch (error) {
        console.error('Error al iniciar sesión:', error);
        alert('Hubo un problema con el inicio de sesión. Inténtalo más tarde.');
    }

});
