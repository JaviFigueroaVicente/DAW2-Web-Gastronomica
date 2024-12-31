document.addEventListener('DOMContentLoaded', function () {
    // Recuperamos la cesta del localStorage
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];

    // Elementos de la página
    const cestaContainer = document.querySelector('.actualizar-direction.actualizar-productos');
    const subtotalContainer = document.querySelector('.precio-subtotal'); // Subtotal sin descuentos
    const totalContainer = document.querySelector('.precio-total'); // Total con descuentos
    const ahorroContainer = document.querySelector('.ahorrado p'); // Ahorro total

    let subtotal = 0;
    let totalConDescuento = 0;

    // Limpiamos el contenedor para evitar duplicados
    cestaContainer.innerHTML = '';

    if (cesta.length === 0) {
        // Si la cesta está vacía, mostramos un mensaje adecuado
        cestaContainer.innerHTML = `
            <div class="cesta-vacia">
                <h2>Tu cesta está vacía</h2>
                <p>Sigue comprando en <a href="?url=index">Mammoth's Kitchen</a> o visita tu <a href="">lista de favoritos</a>.</p>
            </div>`;
        subtotalContainer.textContent = '0,00 €';
        totalContainer.textContent = '0,00 €';
        ahorroContainer.textContent = '* IVA incluido';
        return;
    }

    // Mostrar los productos en el contenedor y calcular totales
    cesta.forEach((producto) => {
        const precioSinDescuento = producto.precio_producto * producto.cantidad;
        const precioConDescuento = precioSinDescuento * (1 - (producto.descuento_oferta || 0) / 100);

        subtotal += precioSinDescuento;
        totalConDescuento += precioConDescuento;

        const productoHTML = `
            <div class="card card-finalizar">
                <a href="?url=productos/producto-individual&id=${producto.id_producto}">
                    <img src="${producto.foto_producto}" class="card-img-top" alt="${producto.nombre_producto}">
                </a>
                <div class="card-body">
                    <h5>${producto.nombre_producto}</h5>
                    <p class="card-text texto-tamaño">Tamaño: ${producto.tamaño}</p>
                    <p class="card-text texto-cantidad">Cantidad: ${producto.cantidad}</p>
                    ${producto.descuento_oferta ? `<p class="card-text texto-descuento">${producto.descuento_oferta}% de descuento</p>` : ''}
                    <p class="card-text texto-precio">${precioConDescuento.toFixed(2).replace('.', ',')} €</p>
                </div>
            </div>
        `;
        cestaContainer.insertAdjacentHTML('beforeend', productoHTML);
    });

    // Mostrar el subtotal sin descuentos
    subtotalContainer.textContent = subtotal.toFixed(2).replace('.', ',') + ' €';

    // Mostrar el total con descuentos
    totalContainer.textContent = totalConDescuento.toFixed(2).replace('.', ',') + ' €';

    // Calcular y mostrar el ahorro total
    const ahorroTotal = subtotal - totalConDescuento;
    if (ahorroTotal > 0) {
        ahorroContainer.innerHTML = `* Has ahorrado ${ahorroTotal.toFixed(2).replace('.', ',')} € (IVA incluido)`;
    } else {
        ahorroContainer.innerHTML = '* IVA incluido';
    }
});


document.getElementById('tramitarPedidoForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Evita el envío predeterminado del formulario

    const idUser = localStorage.getItem('id_user');
    if (!idUser) {
        alert('Error: No se detectó un usuario identificado. Por favor, inicia sesión.');
        return;
    }

    const deliveryOption = document.querySelector('input[name="deliveryOption"]:checked').value;
    const payOption = document.querySelector('input[name="PayOption"]:checked').value;
    const idOferta = localStorage.getItem('id_oferta') || null; // Si no hay oferta, se asigna null
    const products = JSON.parse(localStorage.getItem('cartProducts')) || []; // Productos en el carrito
    let totalPrice = 0;

    // Cálculo del precio total con la lógica de ofertas
    products.forEach(product => {
        const discountMultiplier = product.descuento_oferta ? (1 - product.descuento_oferta / 100) : 1;
        totalPrice += product.precio_producto * product.cantidad * discountMultiplier;
    });

    const orderData = {
        id_user: idUser,
        delivery_option: deliveryOption,
        pay_option: payOption,
        total_price: totalPrice.toFixed(2), // Asegura formato decimal
        id_oferta: idOferta,
        products: products,
    };

    try {
        const response = await fetch('?url=api&action=tramitar-pedido', { // Cambia la URL según tu configuración
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData),
        });

        const result = await response.json();

        if (result.success) {
            alert('Pedido registrado exitosamente. Gracias por tu compra.');
            localStorage.removeItem('id_oferta'); // Limpia el id_oferta si es necesario
            localStorage.removeItem('cartProducts'); // Limpia los productos del carrito
            window.location.href = '?url=cuenta/mis-pedidos'; // Redirige a una página de agradecimiento
        } else {
            alert('Error al registrar el pedido. Por favor, inténtalo más tarde.');
        }
    } catch (error) {
        console.error('Error al registrar el pedido:', error);
        alert('Hubo un problema con el registro del pedido. Inténtalo más tarde.');
    }
});

