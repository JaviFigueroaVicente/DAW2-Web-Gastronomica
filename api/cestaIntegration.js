document.addEventListener('DOMContentLoaded', function () {
    const productosLista = document.getElementById('productos-lista');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');
    const totalArticulosEl = document.getElementById('total-articulos');
    const ahorroEl = document.getElementById('ahorro');
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];

    // Si la cesta está vacía, mostrar mensaje
    if (cesta.length === 0) {
        productosLista.innerHTML = `
            <div class="cesta-vacia">
                <h2>Tu cesta está vacía</h2>
                <p>Sigue comprando en <a href="?url=index">Mammoth's Kitchen</a> o visita tu <a href="">lista de favoritos</a>.</p>
            </div>`;
        return;
    }

    // Actualizar el número total de artículos en la página de finalizar compra
    const totalArticulos = cesta.reduce((acc, producto) => acc + producto.cantidad, 0); // Cuenta la cantidad total de productos
    totalArticulosEl.textContent = `(${totalArticulos} artículo${totalArticulos !== 1 ? 's' : ''})`; // Muestra el total de artículos

    let subtotal = 0;
    let total = 0;
    let ahorro = 0;

    // Generar HTML para cada producto
    cesta.forEach(producto => {
        const descuento = producto.descuento_oferta || 0;
        const precioConDescuento = producto.precio_producto * producto.cantidad * (1 - descuento / 100);
        const precioSinDescuento = producto.precio_producto * producto.cantidad;

        subtotal += precioSinDescuento;
        total += precioConDescuento;
        ahorro += precioSinDescuento - precioConDescuento;

        const cardHTML = `
        <div class="card card-finalizar">
            <a href="?url=productos/producto-individual&id=${producto.id_producto}">
                <img src="${producto.foto_producto}" class="card-img-top" alt="${producto.nombre_producto}">
            </a>
            <div class="card-body">
                <h5>${producto.nombre_producto}</h5>
                <p class="card-text texto-tamaño">Tamaño: ${producto.tamaño}</p>
                <p class="card-text texto-entrega">Entrega estimada, 21:30h 25 oct. 2024</p>                             
                <div class="modificar-producto">  
                    <button data-id="${producto.id_producto}" data-action="reducir" class="btn-reducir" ${producto.cantidad <= 1 ? 'disabled' : ''}>-</button>
                    <input type="text" class="cantidad-producto" value="${producto.cantidad}" readonly>
                    <button data-id="${producto.id_producto}" data-action="aumentar" class="btn-aumentar" ${producto.cantidad >= producto.stock_producto ? 'disabled' : ''}>+</button>
                </div>
                ${descuento ? `<p class="card-text texto-descuento">${descuento}% de descuento</p>` : ''}
            </div>
            <div class="producto-borrar">
                <button data-id="${producto.id_producto}" class="btn-close" aria-label="Close"></button>
                <div>
                    <p class="precio-descuento">${precioConDescuento.toFixed(2).replace('.', ',')} €</p>
                    ${descuento ? `<p class="precio-tachado">${precioSinDescuento.toFixed(2).replace('.', ',')} €</p>` : ''}
                </div>                                              
            </div>
        </div>`;
        productosLista.insertAdjacentHTML('beforeend', cardHTML);
    });

    // Actualizar subtotales y totales
    subtotalEl.textContent = subtotal.toFixed(2).replace('.', ',') + ' €';
    totalEl.textContent = total.toFixed(2).replace('.', ',') + ' €';

    if (ahorro > 0) {
        ahorroEl.innerHTML = `<p class="ahorrado-verde">Has ahorrado ${ahorro.toFixed(2).replace('.', ',')} €</p>`;
    }

    // Event Listeners para modificar cantidad o eliminar producto
    productosLista.addEventListener('click', function (e) {
        const target = e.target;
        const idProducto = target.dataset.id;
        const action = target.dataset.action;

        if (action === 'reducir' || action === 'aumentar') {
            modifyQuantity(idProducto, action);
        }

        if (target.classList.contains('btn-close')) {
            removeProduct(idProducto);
        }
    });

    // Actualizar carrito en el header
    updateCartQuantity();

    // Mostrar los productos en la cesta
    const cestaContainer = document.querySelector('.actualizar-productos');
    const subtotalContainer = document.querySelector('.precio-subtotal');
    const totalContainer = document.querySelector('.precio-total');
    const ahorroContainer = document.querySelector('.ahorrado-verde');
    


    // Limpiamos el contenedor para evitar duplicados
    cestaContainer.innerHTML = '';

    // Recorremos los productos y los mostramos
    cesta.forEach((producto) => {
        // Crear el HTML para cada producto
        const productoDiv = document.createElement('div');
        productoDiv.classList.add('card', 'card-finalizar');
        productoDiv.innerHTML = `
            <a href="?url=productos/producto-individual&id=${producto.id_producto}">
                <img src="data:image/webp;base64,${producto.foto_producto}" class="card-img-top" alt="${producto.nombre_producto}">
            </a>
            <div class="card-body">
                <h5><a href="?url=productos/producto-individual&id=${producto.id_producto}">${producto.nombre_producto}</a></h5>
                <p class="card-text texto-tamaño comment">Tamaño: ${producto.tamaño}</p>
                <div class="producto-borrar">
                    <p class="card-text texto-cantidad comment">Cantidad: ${producto.cantidad}</p>
                    <p>${(producto.precio_producto * producto.cantidad * (1 - producto.descuento_oferta / 100)).toFixed(2)}€</p>
                </div>
            </div>
        `;

        // Agregar el producto al contenedor de la cesta
        cestaContainer.appendChild(productoDiv);

        // Calcular el subtotal sin descuento y con descuento
        const precioSinDescuento = producto.precio_producto * producto.cantidad;
        subtotal += precioSinDescuento;
        totalSinDescuento += precioSinDescuento;

        if (producto.descuento_oferta) {
            const precioConDescuento = precioSinDescuento * (1 - producto.descuento_oferta / 100);
            totalConDescuento += precioConDescuento;
        } else {
            totalConDescuento += precioSinDescuento;
        }
    });

    // Mostrar el subtotal
    subtotalContainer.textContent = subtotal.toFixed(2).replace('.', ',') + ' €';

    // Mostrar el total con descuento (si aplica)
    totalContainer.textContent = totalConDescuento.toFixed(2).replace('.', ',') + ' €';

    // Calcular y mostrar el ahorro
    if (totalSinDescuento !== totalConDescuento) {
        const ahorro = totalSinDescuento - totalConDescuento;
        ahorroContainer.textContent = `Has ahorrado ${ahorro.toFixed(2).replace('.', ',')}€`;
    } else {
        ahorroContainer.style.display = 'none';  // Si no hay ahorro, ocultamos el mensaje
    }
});

// Modificar cantidad de productos
function modifyQuantity(idProducto, action) {
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    const producto = cesta.find(item => item.id_producto === idProducto);

    if (!producto) return;

    if (action === 'reducir' && producto.cantidad > 1) {
        producto.cantidad--;
    } else if (action === 'aumentar' && producto.cantidad < producto.stock_producto) {
        producto.cantidad++;
    }

    localStorage.setItem('cesta', JSON.stringify(cesta));
    location.reload(); // Actualiza la vista
}

// Eliminar producto
function removeProduct(idProducto) {
    let cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    cesta = cesta.filter(item => item.id_producto !== idProducto);

    localStorage.setItem('cesta', JSON.stringify(cesta));
    location.reload(); // Actualiza la vista
}

// Función para actualizar la cantidad total de productos en el carrito (header)
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
