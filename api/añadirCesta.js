document.addEventListener('DOMContentLoaded', () => {
    const cestaKey = 'cartProducts';

    // Evento para añadir producto a la cesta
    const addToCartButton = document.querySelector('.cesta-compra');
    if (addToCartButton) {
        addToCartButton.addEventListener('click', function () {
            // Recopilación de datos del producto
            const idProducto = this.dataset.id;
            const nombreProducto = this.dataset.nombre;
            const precioProducto = parseFloat(this.dataset.precio);
            const fotoProducto = this.dataset.foto;
            const stockProducto = parseInt(this.dataset.stock, 10);
            const cantidad = parseInt(document.querySelector('.cantidad-productos').value, 10);
            const tamaño = document.querySelector('input[name="tamaño"]:checked')?.value;

            // Validar que los campos necesarios no estén vacíos
            if (!idProducto || !tamaño || isNaN(cantidad) || cantidad <= 0) {
                alert('Por favor, selecciona un tamaño y cantidad válida.');
                return;
            }

            // Objeto del producto a añadir
            const producto = {
                id_producto: idProducto,
                nombre_producto: nombreProducto,
                precio_producto: precioProducto,
                foto_producto: fotoProducto,
                stock_producto: stockProducto,
                cantidad: cantidad,
                tamaño: tamaño,
            };

            // Recuperar cesta actual
            const cesta = JSON.parse(localStorage.getItem(cestaKey)) || [];

            // Comprobar si el producto ya existe en la cesta
            const productoExistente = cesta.find(
                item => item.id_producto === idProducto && item.tamaño === tamaño
            );

            if (productoExistente) {
                // Incrementar la cantidad del producto existente
                productoExistente.cantidad += cantidad;
            } else {
                // Añadir nuevo producto
                cesta.push(producto);
            }

            // Guardar la cesta actualizada en localStorage
            localStorage.setItem(cestaKey, JSON.stringify(cesta));

            // Mostrar un mensaje o actualizar el DOM si es necesario
            alert('Producto añadido a la cesta correctamente.');
        });
    }
});