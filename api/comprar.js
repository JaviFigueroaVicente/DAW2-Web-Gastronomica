document.addEventListener('DOMContentLoaded', function () {
    const cesta = JSON.parse(localStorage.getItem('cartProducts')) || [];
    const cuponAplicado = JSON.parse(localStorage.getItem('appliedCoupon')) || null;

    const cestaContainer = document.querySelector('.actualizar-direction.actualizar-productos');
    const subtotalContainer = document.querySelector('.precio-subtotal');
    const totalContainer = document.querySelector('.precio-total');
    const ahorroContainer = document.querySelector('.ahorrado p');

    cestaContainer.innerHTML = ''; // Limpiar el contenedor inicial

    if (cesta.length === 0) {
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

    let subtotalCalculado = 0;
    let totalConDescuentoCalculado = 0;

    cesta.forEach((producto) => {
        const precioSinDescuento = producto.precio_producto * producto.cantidad;

        // Calcular el descuento del producto
        const descuentoOferta = producto.descuento_oferta || 0;
        const precioConDescuentoOferta = precioSinDescuento * (1 - descuentoOferta / 100);

        // Calcular descuento adicional por cupón
        const descuentoCupon = cuponAplicado ? cuponAplicado.discount : 0;
        const precioFinalConDescuento = precioConDescuentoOferta * (1 - descuentoCupon / 100);

        // Acumulación de subtotales y totales
        subtotalCalculado += precioSinDescuento;
        totalConDescuentoCalculado += precioFinalConDescuento;

        // Generar el HTML para cada producto
        const productoHTML = `
            <div class="card card-finalizar">
                <a href="?url=productos/producto-individual&id=${producto.id_producto}">
                    <img src="${producto.foto_producto}" class="card-img-top" alt="${producto.nombre_producto}">
                </a>
                <div class="card-body">
                    <h5>${producto.nombre_producto}</h5>
                    <p class="card-text texto-tamaño">Tamaño: ${producto.tamaño}</p>
                    <p class="card-text texto-cantidad">Cantidad: ${producto.cantidad}</p>
                    ${descuentoOferta ? `<p class="card-text texto-descuento">${descuentoOferta}% de descuento</p>` : ''}
                    ${descuentoCupon ? `<p class="card-text texto-cupon">${descuentoCupon}% de descuento adicional</p>` : ''}
                    <p class="card-text texto-precio">
                        <span class="precio-final">${precioFinalConDescuento.toFixed(2).replace('.', ',')} €</span>
                        ${descuentoOferta ? `<span class="precio-oferta">${precioConDescuentoOferta.toFixed(2).replace('.', ',')} €</span>` : ''}
                        <span class="precio-original">${precioSinDescuento.toFixed(2).replace('.', ',')} €</span>
                    </p>
                </div>
            </div>
        `;
        cestaContainer.insertAdjacentHTML('beforeend', productoHTML);
    });

    // Guardar descuentos en LocalStorage
    const descuentoOfertaTotal = subtotalCalculado - totalConDescuentoCalculado;
    const descuentoCuponTotal = cuponAplicado ? cuponAplicado.discount : 0;
    localStorage.setItem('descuentoOferta', descuentoOfertaTotal.toFixed(2));
    localStorage.setItem('descuentoCupon', descuentoCuponTotal);

    // Actualizar el subtotal y total con descuento
    subtotalContainer.textContent = subtotalCalculado.toFixed(2).replace('.', ',') + ' €';
    totalContainer.textContent = totalConDescuentoCalculado.toFixed(2).replace('.', ',') + ' €';

    // Calcular y mostrar ahorro total
    const ahorroCalculado = subtotalCalculado - totalConDescuentoCalculado;
    ahorroContainer.textContent = ahorroCalculado > 0 
        ? `* Has ahorrado ${ahorroCalculado.toFixed(2).replace('.', ',')} € (IVA incluido)` 
        : '* IVA incluido';

    // Guardar en el LocalStorage para referencia
    localStorage.setItem('subtotal', subtotalCalculado);
    localStorage.setItem('total', totalConDescuentoCalculado);
    localStorage.setItem('ahorro', ahorroCalculado);
});


document.addEventListener('DOMContentLoaded', function () {
    const tramitarPedidoForm = document.getElementById('tramitarPedidoForm');
    
    tramitarPedidoForm.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Obtener los datos del formulario
        const deliveryOption = document.querySelector('input[name="deliveryOption"]:checked').value;
        const payOption = document.querySelector('input[name="PayOption"]:checked').value;
        const products = JSON.parse(localStorage.getItem('cartProducts')) || [];
        const idOferta = localStorage.getItem('appliedCoupon') ? JSON.parse(localStorage.getItem('appliedCoupon')).id : null;

        // Validación de datos
        if (!deliveryOption || !payOption || products.length === 0) {
            alert('Por favor, complete todos los campos.');
            return;
        }

        // Crear un objeto con los datos a enviar
        const data = {
            delivery_option: deliveryOption,
            pay_option: payOption,
            products: products,
            id_oferta: idOferta
        };

        // Enviar los datos al servidor
        fetch('?url=api&action=tramitar-pedido', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Vaciar la cesta del localStorage
                localStorage.removeItem('cartProducts');
                localStorage.removeItem('appliedCoupon');
                localStorage.removeItem('subtotal');
                localStorage.removeItem('total');
                localStorage.removeItem('ahorro');

                // Redirigir al usuario a una página de confirmación de pedido, por ejemplo
                window.location.href = `?url=cuenta/mis-pedidos`;
            } else {
                alert(result.message || 'Ocurrió un error al tramitar el pedido.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error. Por favor, inténtalo de nuevo.');
        });
    });
});