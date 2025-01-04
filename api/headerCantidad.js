document.addEventListener('DOMContentLoaded', function () {
    // Llamada a la función para actualizar el contador de productos
    updateCartQuantity();

    // Event listener para cambios en el carrito (si se actualiza la cesta)
    document.querySelectorAll('.modificar-producto button').forEach(button => {
        button.addEventListener('click', function () {
            updateCartQuantity(); // Actualiza el contador cuando se modifica el carrito
        });
    });

    const userId = sessionStorage.getItem('id_user');
    const userName = sessionStorage.getItem('nombre');
    const userRole = sessionStorage.getItem('admin'); // Asumiendo que tienes el rol almacenado también.

    const menuText = document.getElementById('menuText');
    const menuDropdown = document.getElementById('menuDropdown');
    const loginMenu = document.getElementById('loginMenu');
    const registerMenu = document.getElementById('registerMenu');
    const divider = document.getElementById('divider');

    if (userId && userName) {
        // Cambiar el texto del botón
        menuText.textContent = 'Mi cuenta';

        // Ocultar las opciones de iniciar sesión y registro
        loginMenu.style.display = 'none';
        registerMenu.style.display = 'none';
        divider.style.display = 'none';

        // Crear las opciones del usuario logueado
        const userGreeting = document.createElement('li');
        userGreeting.innerHTML = `<p class="dropdown-item nombre-desplegable">Hola <a href="?url=cuenta">${userName}</a></p>`;
        menuDropdown.appendChild(userGreeting);

        const userLinks = document.createElement('li');
        userLinks.className = 'ul-dropdown';
        userLinks.innerHTML = `
            <ul class="lista-dropdown">
                <li><a class="a-log" href="?url=cuenta">Mi cuenta</a></li>
                <li><a class="a-log" href="?url=cuenta/mis-pedidos">Mis pedidos</a></li>
                <li><a class="a-log" href="">Atención al cliente</a></li>
                ${userRole === '1' ? '<li><a class="a-log" href="?url=admin">Administración</a></li>' : ''}
            </ul>
        `;
        menuDropdown.appendChild(userLinks);

        const logoutOption = document.createElement('li');
        logoutOption.innerHTML = `<a class="a-log" href="" id="logout-btn">Cerrar sesión</a>`;
        menuDropdown.appendChild(logoutOption);
    }

    // Event delegation to handle logout click
    document.addEventListener('click', function (e) {
        if (e.target && e.target.id === 'logout-btn') {
            e.preventDefault(); // Prevent the default link behavior

            // Clear sessionStorage (remove all items)
            sessionStorage.clear();

            // Clear the cart
            localStorage.removeItem('cartProducts');
            updateCartQuantity(); // Update cart display

            // Redirect the user to the login page
            window.location.href = "?url=login";
        }
    });
});

// Actualizar la cantidad total de productos en el header
function updateCartQuantity() {
    const cesta = JSON.parse(localStorage.getItem('cartProducts')) || [];
    const totalProductos = cesta.reduce((acc, producto) => acc + producto.cantidad, 0); // Suma las cantidades de todos los productos
    const cantidadProductosEl = document.getElementById('cantidad-productos');

    if (totalProductos === 0) {
        cantidadProductosEl.textContent = ''; // Si es 0, no muestra nada
        cantidadProductosEl.style.display = 'none'; // También puede esconder el contador si es 0
    } else {
        cantidadProductosEl.textContent = totalProductos; // Muestra la cantidad de productos
        cantidadProductosEl.style.display = 'inline'; // Asegura que se vea si hay productos
    }
}
