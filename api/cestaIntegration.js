document.addEventListener('DOMContentLoaded', function () {
    try {
        const productosLista = document.getElementById('productos-lista');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');
        const totalArticulosEl = document.getElementById('total-articulos');
        const ahorroEl = document.getElementById('ahorro');
        const formCupon = document.getElementById('form-cupon');
        const cestaKey = 'cartProducts';

        let cesta = JSON.parse(localStorage.getItem(cestaKey)) || [];
        let cuponAplicado = null;

        if (cesta.length === 0) {
            productosLista.innerHTML = `
                <div class="cesta-vacia">
                    <h2>Tu cesta está vacía</h2>
                    <p>Sigue comprando en <a href="?url=index">Mammoth's Kitchen</a> o visita tu <a href="">lista de favoritos</a>.</p>
                </div>`;
            if (subtotalEl) subtotalEl.textContent = '0,00 €';
            if (totalEl) totalEl.textContent = '0,00 €';
            if (ahorroEl) ahorroEl.innerHTML = '* IVA incluido';
            return;
        }

        let subtotal = 0;
        let total = 0;
        let ahorro = 0;

        function renderCesta() {
            productosLista.innerHTML = '';
            subtotal = 0;
            total = 0;
            ahorro = 0;

            cesta.forEach(producto => {
                if (!producto.id_producto || !producto.precio_producto || !producto.cantidad) {
                    console.warn("Producto con datos incompletos:", producto);
                    return;
                }

                const descuento = cuponAplicado ? cuponAplicado.discount : 0;
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

            localStorage.setItem('subtotal', subtotal.toFixed(2));
            localStorage.setItem('total', total.toFixed(2));
            localStorage.setItem('ahorro', ahorro.toFixed(2));

            if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2).replace('.', ',') + ' €';
            if (totalEl) totalEl.textContent = total.toFixed(2).replace('.', ',') + ' €';
            if (ahorro > 0 && ahorroEl) {
                ahorroEl.innerHTML = `<p class="ahorrado-verde">Has ahorrado ${ahorro.toFixed(2).replace('.', ',')} €</p>`;
            } else if (ahorroEl) {
                ahorroEl.innerHTML = '* IVA incluido';
            }
        }

        function actualizarTotalArticulos() {
            const totalArticulos = cesta.reduce((total, producto) => total + producto.cantidad, 0);
            totalArticulosEl.textContent = `(${totalArticulos} artículos)`;
        }

        renderCesta();
        actualizarTotalArticulos();

        formCupon.addEventListener('submit', async function (e) {
            e.preventDefault();
            const cuponInput = formCupon.querySelector('input[name="cupon_code"]');
            const cuponCode = cuponInput.value.trim();

            if (!cuponCode) {
                alert("Por favor, ingrese un código de cupón.");
                return;
            }

            try {
                const response = await fetch('?url=api&action=cupones', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ cupon_code: cuponCode })
                });

                if (!response.ok) {
                    throw new Error("Error en la comunicación con el servidor.");
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || "Error al aplicar el cupón.");
                }

                cuponAplicado = { discount: data.discount };
                alert(`Cupón "${cuponCode}" aplicado con éxito. Descuento: ${data.discount}%`);
                renderCesta();
                actualizarTotalArticulos();
            } catch (error) {
                console.error('Error al aplicar el cupón:', error.message);
                alert(`Error: ${error.message}`);
            }
        });

        productosLista.addEventListener('click', function (e) {
            const target = e.target;
            const idProducto = target.dataset.id;
            const action = target.dataset.action;

            if (action === 'reducir' || action === 'aumentar') {
                modifyQuantity(idProducto, action);
                actualizarTotalArticulos();
            }

            if (target.classList.contains('btn-close')) {
                removeProduct(idProducto);
                actualizarTotalArticulos();
            }
        });

        function modifyQuantity(idProducto, action) {
            const producto = cesta.find(p => p.id_producto === idProducto);
            if (!producto) return;

            if (action === 'reducir' && producto.cantidad > 1) {
                producto.cantidad -= 1;
            } else if (action === 'aumentar' && producto.cantidad < producto.stock_producto) {
                producto.cantidad += 1;
            }

            localStorage.setItem('cartProducts', JSON.stringify(cesta));
            renderCesta();
            actualizarTotalArticulos();
        }

        function removeProduct(idProducto) {
            const index = cesta.findIndex(p => p.id_producto === idProducto);
            if (index !== -1) {
                cesta.splice(index, 1);
                localStorage.setItem(cestaKey, JSON.stringify(cesta));
                renderCesta();
                actualizarTotalArticulos();
            }
        }
    } catch (error) {
        console.error("Error cargando la cesta:", error);
    }
});
