document.addEventListener('DOMContentLoaded', function () {
    // Llamada a la función para actualizar el contador de productos
    updateCartQuantity();

    // Event listener para cambios en el carrito (si se actualiza la cesta)
    document.querySelectorAll('.modificar-producto button').forEach(button => {
        button.addEventListener('click', function () {
            updateCartQuantity(); // Actualiza el contador cuando se modifica el carrito
        });
    });
});

// Actualizar la cantidad total de productos en el header
function updateCartQuantity() {
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];
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
