import { ProductosAPI } from "./productosAPI.js";
import { PedidosAPI } from "./pedidosAPI.js";
import { UserAPI } from "./userAPI.js";
import { LogsAPI } from "./logsAPI.js";

document.addEventListener("DOMContentLoaded", () => {
    const idUserElement = document.getElementById('session-data');
    const idUser = idUserElement.dataset.idUser;
    
    // Almacena el ID en sessionStorage
    sessionStorage.setItem('id_user', idUser);
    
    // Recupera el valor almacenado desde sessionStorage
    const sessionUser = sessionStorage.getItem('id_user');
    
    // Imprime el valor almacenado
    console.log("ID User almacenado:", sessionUser);
    const productosAPI = new ProductosAPI('?url=api');
    const pedidosAPI = new PedidosAPI('?url=api'); 
    const userAPI = new UserAPI('?url=api');
    const logsAPI = new LogsAPI('?url=api');// Define la URL base de tu API
    const radioProductos = document.getElementById("vbtn-radio1");
    const radioPedidos= document.getElementById("vbtn-radio2");
    const radioUsuarios = document.getElementById("vbtn-radio3");
    const radioLogs = document.getElementById("vbtn-radio4");
    const tablaMostrar = document.getElementById("tabla-mostrar");
    
    

    radioProductos.addEventListener("change", async () => {
        if (radioProductos.checked) {
            cargarProductos(); 
            // Llamar a cargar productos cuando se selecciona la opción
        } 
    });

    radioPedidos.addEventListener("change", async () => {
        if (radioPedidos.checked) {
            cargarPedidos(); 
        }
    });

    radioUsuarios.addEventListener("change", async () => {
        if (radioUsuarios.checked) {
            cargarUsuarios();
        }
    });

    radioLogs.addEventListener("change", async () => {
        if (radioLogs.checked) {
            cargarLogs();
        }
    });

  
    async function cargarProductos() {
        try {
            // Llamada a la API para obtener productos
            const productos = await productosAPI.getProductos();
    
            // Construir la tabla con los datos
            const tablaHTML = `
                <button class="btn btn-primary btn-sm create-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear Producto</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>ID Categoria Producto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productos.map(producto => `
                            <tr>
                                <td>${producto.id_producto}</td>
                                <td>
                                    ${
                                        producto.foto_producto
                                            ? `<img src="${producto.foto_producto}" alt="Imagen de ${producto.nombre_producto}" style="width: 50px; height: 50px; object-fit: cover;">`
                                            : "Sin imagen"
                                    }
                                </td>
                                <td>${producto.nombre_producto}</td>
                                <td>${producto.descripcion_producto}</td>
                                <td>${producto.precio_producto} €</td>
                                <td>${producto.stock_producto}</td>
                                <td>${producto.id_categoria_producto}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editar-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${producto.id_producto}">Editar</button>
                                    <button class="btn btn-danger btn-sm eliminar-btn" data-id="${producto.id_producto}">Eliminar</button>    
                                </td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
            `;
    
            // Insertar la tabla en el contenedor
            tablaMostrar.innerHTML = tablaHTML;
    
            // Agregar eventos de clic a los botones "Editar"
            agregarEventosEditar();
            agregarEventosEliminar();
            agregarEventosCreate();
    
        } catch (error) {
            // Mostrar mensaje de error
            tablaMostrar.innerHTML = "<p>Error al cargar productos. Inténtalo de nuevo más tarde.</p>";
        }
    }

    async function editarProducto(id) {
        const modalMostrar = document.querySelector(".modal-content"); // Contenedor del modal
    
        try {
            // Obtener los detalles del producto
            const producto = await productosAPI.getProductoIndividual(id);
    
            // Construir el contenido del modal
            const modalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarProductoForm" enctype="multipart/form-data">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="${producto.nombre_producto}" required>
                        
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="${producto.descripcion_producto}" required>
                        
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" value="${producto.precio_producto}" step="0.01" required>
                        
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="${producto.stock_producto}" min="0" required>
                        
                        <label for="id_categoria_producto" class="form-label">ID categoria producto</label>
                        <input type="number" class="form-control" id="id_categoria_producto" name="id_categoria_producto" value="${producto.id_categoria_producto}" required>

                        <label for="foto_producto" class="form-label">Actualizar Imagen (Opcional)</label>
                        <input type="file" class="form-control" id="foto_producto" name="foto_producto" accept="image/*">
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;
    
            // Mostrar el formulario
            modalMostrar.innerHTML = modalHTML;
    
            // Manejar el envío del formulario
            const form = document.getElementById("editarProductoForm");
            form.addEventListener("submit", async (event) => {
                event.preventDefault();
    
                // Construir el formulario de datos
                const formData = new FormData();
                formData.append("id_producto", id);
                formData.append("nombre_producto", form.nombre.value);
                formData.append("descripcion_producto", form.descripcion.value);
                formData.append("precio_producto", parseFloat(form.precio.value));
                formData.append("id_categoria_producto", parseInt(form.id_categoria_producto.value, 10));
                formData.append("stock_producto", parseInt(form.stock.value, 10));
    
                // Agregar la imagen si fue seleccionada
                if (form.foto_producto.files.length > 0) {
                    formData.append("foto_producto", form.foto_producto.files[0]);
                }
    
                try {
                    // Enviar datos al servidor
                    await productosAPI.updateProducto(formData);
                    alert("Producto actualizado correctamente.");
                    await registerLog('UPDATE', 'PRODUCTOS', id);
                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
    
                    // Recargar la tabla de productos
                    cargarProductos();
    
                } catch (error) {
                    console.error("Error al actualizar el producto:", error);
                    alert("Error al actualizar el producto. Inténtalo de nuevo.");
                }
            });
    
        } catch (error) {
            console.error("Error al cargar el producto:", error);
            modalMostrar.innerHTML = "<p>Error al cargar el producto. Inténtalo de nuevo más tarde.</p>";
        }
    }
    

    function agregarEventosEditar() {
        const botonesEditar = document.querySelectorAll('.editar-btn');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idProducto = e.target.getAttribute('data-id');
                editarProducto(idProducto);
            });
        });
    }

    

    function agregarEventosEliminar() {
        const botonesEliminar = document.querySelectorAll('.eliminar-btn');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idProducto = e.target.getAttribute('data-id');
                const confirmar = confirm("¿Estás seguro de que deseas eliminar este producto?");
                if (confirmar) {
                    deleteProducto(idProducto); // Llamar a la función para eliminar el producto
                }
            });
        });
    }

    function agregarEventosCreate(){
        const botonCreate = document.querySelector('.create-btn');
        botonCreate.addEventListener('click', (e) => {
            createProducto();
        });
    }
    

    async function deleteProducto(id) {
        try {
            // Llamada a la API para eliminar el producto
            await registerLog('DELETE', 'PRODUCTOS', id);
            await productosAPI.deleteProducto(id);
            alert("Producto eliminado correctamente.");
    
            // Recargar la tabla de productos
            cargarProductos();
    
        } catch (error) {
            alert("Error al eliminar el producto. Inténtalo de nuevo.");
        }
    }

   

    async function createProducto() {
        const modalMostrar = document.querySelector(".modal-content"); // Contenedor del modal
    
        try {
            // Construir el contenido del modal para la creación del producto
            let createProductoModalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="crearProductoForm" enctype="multipart/form-data">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>

                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>

                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>

                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" required>

                        <label for="id_categoria_producto" class="form-label">ID Categoría</label>
                        <input type="number" class="form-control" id="id_categoria_producto" name="id_categoria_producto" min="1" required>

                        <label for="foto_producto" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="foto_producto" name="foto_producto" accept="image/*" required>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;
    
            modalMostrar.innerHTML = createProductoModalHTML;
    
            // Manejar el envío del formulario
            const form = document.getElementById("crearProductoForm");
            form.addEventListener("submit", async (event) => {
                event.preventDefault();
    
                const formData = new FormData();
                formData.append("nombre_producto", form.nombre.value);
                formData.append("descripcion_producto", form.descripcion.value);
                formData.append("precio_producto", parseFloat(form.precio.value));
                formData.append("stock_producto", parseInt(form.stock.value, 10));
                formData.append("id_categoria_producto", parseInt(form.id_categoria_producto.value));
                formData.append("foto_producto", form.foto_producto.files[0]);
    
                try {
                    // Llamada a la API para crear el producto
                    await productosAPI.createProducto(formData);
                    await registerLog('CREATE', 'PRODUCTOS', null);
                    alert("Producto creado correctamente.");
    
                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
    
                    // Recargar la tabla de productos
                    cargarProductos();
    
                } catch (error) {
                    alert("Error al crear el producto. Inténtalo de nuevo.");
                }
            });
    
        } catch (error) {
            alert("Error al cargar el formulario de creación de producto. Inténtalo de nuevo.");
        }
    }

    async function cargarPedidos() {
        try {
            const pedidos = await pedidosAPI.getPedidos();
    
            const columnas = [
                { key: "id_pedido", label: "ID Pedido" },
                { key: "fecha_pedido", label: "Fecha Pedido" },
                { key: "estado_pedido", label: "Estado" },
                { key: "id_user_pedido", label: "Cliente" },
                { key: "precio_pedido", label: "Precio" },
                { key: "direccion_pedido", label: "Dirección" },
                { key: "metodo_pago", label: "Método de Pago" },
            ];
    
            let sortBy = null;
            let sortOrder = 'asc'; // Ordenación ascendente por defecto
            let currentCurrency = 'EUR'; // Moneda actual por defecto (Euro)
            let exchangeRates = {}; // Almacenará los tipos de cambio
    
            const apiKey = 'fca_live_gkcvBGnOgtkAQE1cL57EPOv0GEdSe1ifpHNd1i6i';
    
            // Mapeo de símbolos de divisas
            const currencySymbols = {
                USD: '$',
                EUR: '€',
                GBP: '£',
                JPY: '¥'
            };
    
            // Función para obtener los tipos de cambio
            async function obtenerTiposCambio(baseCurrency) {
                const url = `https://api.freecurrencyapi.com/v1/latest?apikey=${apiKey}&base_currency=${baseCurrency}`;
                try {
                    const response = await fetch(url);
                    const data = await response.json();
                    if (response.ok) {
                        return data.data; // Retorna los tipos de cambio
                    } else {
                        console.error("Error al obtener los tipos de cambio:", data);
                        return {};
                    }
                } catch (error) {
                    console.error("Error en la solicitud de tipos de cambio:", error);
                    return {};
                }
            }
    
            // Solicitar los tipos de cambio iniciales
            exchangeRates = await obtenerTiposCambio('EUR');
    
            // Función para convertir precios
            function convertirPrecio(precio, targetCurrency) {
                if (!exchangeRates[targetCurrency]) return `${precio} €`; // Si no hay tasa, retorna precio original en EUR
                const convertedPrice = (precio * exchangeRates[targetCurrency]).toFixed(2);
                const symbol = currencySymbols[targetCurrency] || targetCurrency;
                return `${convertedPrice} ${symbol}`;
            }
    
            // Función para ordenar los pedidos
            function ordenarPedidos(pedidos, sortBy, sortOrder) {
                return pedidos.sort((a, b) => {
                    const valA = a[sortBy];
                    const valB = b[sortBy];
    
                    // Comparar valores en función de su tipo
                    if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                    if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });
            }
    
            // Función para manejar el clic en los encabezados para ordenar
            function ordenarPorColumna(columna) {
                if (sortBy === columna) {
                    sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    sortBy = columna;
                    sortOrder = 'asc';
                }
    
                const pedidosOrdenados = ordenarPedidos(pedidos, sortBy, sortOrder);
                renderizarTabla(pedidosOrdenados);
            }
    
            // Función para renderizar la tabla con los pedidos
            function renderizarTabla(pedidos) {
                let tablaHTML = `
                    <button class="btn btn-primary btn-sm create-pedido-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear Pedido</button>
                    <div class="currency-selector">
                        <label for="currency-select">Moneda:</label>
                        <select id="currency-select" class="form-select">
                            <option value="USD" ${currentCurrency === 'USD' ? 'selected' : ''}>USD</option>
                            <option value="EUR" ${currentCurrency === 'EUR' ? 'selected' : ''}>EUR</option>
                            <option value="GBP" ${currentCurrency === 'GBP' ? 'selected' : ''}>GBP</option>
                            <option value="JPY" ${currentCurrency === 'JPY' ? 'selected' : ''}>JPY</option>
                        </select>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                ${columnas.map(col => `
                                    <th class="sortable" data-column="${col.key}">
                                        ${col.label}
                                        <span class="sort-indicator"></span>
                                    </th>
                                `).join('')}
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
    
                pedidos.forEach(pedido => {
                    tablaHTML += `
                        <tr>
                            ${columnas.map(col => {
                                const value = col.key === "precio_pedido" 
                                    ? convertirPrecio(pedido[col.key], currentCurrency) 
                                    : pedido[col.key];
                                return `<td>${value ?? ''}</td>`;
                            }).join('')}
                            <td>
                                <button class="btn btn-primary btn-sm editar-pedido-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${pedido.id_pedido}">Editar</button>
                                <button class="btn btn-danger btn-sm eliminar-pedido-btn" data-id="${pedido.id_pedido}">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
    
                tablaHTML += `</tbody></table>`;
                tablaMostrar.innerHTML = tablaHTML;
    
                // Agregar eventos al selector de moneda
                document.getElementById('currency-select').addEventListener('change', async (event) => {
                    currentCurrency = event.target.value;
                    if (!exchangeRates[currentCurrency]) {
                        exchangeRates = await obtenerTiposCambio('EUR'); // Vuelve a solicitar los tipos si no están cargados
                    }
                    renderizarTabla(pedidos);
                });
    
                // Agregar eventos a los encabezados de la tabla
                const sortColumns = document.querySelectorAll('.sortable');
                sortColumns.forEach(col => {
                    col.addEventListener('click', () => {
                        const column = col.getAttribute('data-column');
                        ordenarPorColumna(column);
                    });
                });
    
                // Actualizar indicadores de ordenación
                actualizarIndicadoresOrdenacion();
            }
    
            // Función para actualizar las flechas de ordenación
            function actualizarIndicadoresOrdenacion() {
                const sortColumns = document.querySelectorAll('.sortable');
                sortColumns.forEach(col => {
                    const indicator = col.querySelector('.sort-indicator');
                    if (sortBy && col.getAttribute('data-column') === sortBy) {
                        indicator.textContent = sortOrder === 'asc' ? '↑' : '↓';
                    } else {
                        indicator.textContent = '';
                    }
                });
            }
    
            // Renderizar la tabla por primera vez
            renderizarTabla(pedidos);
    
        } catch (error) {
            tablaMostrar.innerHTML = "<p>Error al cargar pedidos. Inténtalo de nuevo más tarde.</p>";
        }
    
        agregarEventosCreatePedidos();
        agregarEventosEditarPedidos();
        agregarEventosEliminarPedidos();
    }
    
    
    
    

    function agregarEventosEditarPedidos() {
        const botonesEditar = document.querySelectorAll('.editar-pedido-btn');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idPedido = e.target.getAttribute('data-id');
                editarPedido(idPedido);
            });
        });
    }

    function agregarEventosEliminarPedidos() {
        const botonesEliminar = document.querySelectorAll('.eliminar-pedido-btn');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idPedido = e.target.getAttribute('data-id');
                const confirmar = confirm("¿Estás seguro de que deseas eliminar este pedido?");
                if (confirmar) {
                    deletePedido(idPedido);
                }
            });
        });
    }

    function agregarEventosCreatePedidos() {
        const botonCreate = document.querySelector('.create-pedido-btn');
        botonCreate.addEventListener('click', () => {
            createPedido();
        });
    }

    // Define funciones para editar, eliminar y crear pedidos
    async function editarPedido(id) {
        const modalMostrar = document.querySelector(".modal-content"); // Contenedor del modal
    
        try {
            // Obtener los detalles del pedido
            const pedido = await pedidosAPI.getPedidoIndividual(id);
    
            // Construir el contenido del modal
            const modalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarPedidoForm">
                        
                        <label for="fecha_pedido" class="form-label">Fecha del Pedido</label>
                        <input class="form-control" type="datetime-local" id="fecha_pedido" name="fecha_pedido" 
                            value="${new Date(pedido.fecha_pedido).toISOString().slice(0, 16)}" required>
                        
                        <label for="estado_pedido" class="form-label">Estado</label>
                        <select id="estado_pedido" class="form-control" name="estado_pedido" required>
                            <option value="Pendiente" ${pedido.estado_pedido === "Pendiente" ? "selected" : ""}>Pendiente</option>
                            <option value="En Proceso" ${pedido.estado_pedido === "En Proceso" ? "selected" : ""}>En Proceso</option>
                            <option value="Completado" ${pedido.estado_pedido === "Completado" ? "selected" : ""}>Completado</option>
                            <option value="Cancelado" ${pedido.estado_pedido === "Cancelado" ? "selected" : ""}>Cancelado</option>
                        </select>
    
                        <label for="id_user_pedido" class="form-label">Usuario ID</label>
                        <input type="number" class="form-control" id="id_user_pedido" name="id_user_pedido" 
                            value="${pedido.id_user_pedido}" required>
                        
                        <label for="precio_pedido" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio_pedido" name="precio_pedido" 
                            value="${pedido.precio_pedido}" step="0.01" required>
                        
                        <label for="direccion_pedido" class="form-label">Dirección</label>
                        <input type="text" id="direccion_pedido" class="form-control" name="direccion_pedido" 
                            value="${pedido.direccion_pedido}" required>
                        
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select id="metodo_pago" class="form-control" name="metodo_pago" required>
                            <option value="Tarjeta" ${pedido.metodo_pago === "Tarjeta" ? "selected" : ""}>Tarjeta</option>
                            <option value="Efectivo" ${pedido.metodo_pago === "Efectivo" ? "selected" : ""}>Efectivo</option>
                            <option value="Transferencia" ${pedido.metodo_pago === "Transferencia" ? "selected" : ""}>Transferencia</option>
                        </select>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;
    
            // Mostrar el formulario
            modalMostrar.innerHTML = modalHTML;
    
            // Manejar el envío del formulario
            const form = document.getElementById("editarPedidoForm");
            form.addEventListener("submit", async (event) => {
                event.preventDefault();
    
                // Construir el formulario de datos
                const formData = new FormData();
                formData.append("id_pedido", id);
                formData.append("fecha_pedido", form.fecha_pedido.value);
                formData.append("estado_pedido", form.estado_pedido.value);
                formData.append("id_user_pedido", form.id_user_pedido.value);
                formData.append("precio_pedido", parseFloat(form.precio_pedido.value));
                formData.append("direccion_pedido", form.direccion_pedido.value);
                formData.append("metodo_pago", form.metodo_pago.value);
    
                try {
                    const response = await pedidosAPI.updatePedido(formData);
                    await registerLog('UPDATE', 'PEDIDOS', id);
                    if (response.success) {
                        alert("Pedido actualizado correctamente.");
                    } else {
                        alert(response.error || "Error al actualizar el pedido.");
                    }
    
                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
    
                    // Recargar la tabla de pedidos
                    cargarPedidos();
                } catch (error) {
                    console.error("Error al actualizar el pedido:", error);
                    alert("Error al actualizar el pedido. Inténtalo de nuevo.");
                }
            });
    
        } catch (error) {
            console.error("Error al cargar el pedido:", error);
            modalMostrar.innerHTML = "<p>Error al cargar el pedido. Inténtalo de nuevo más tarde.</p>";
        }
    }
    

    async function deletePedido(id) {
        try {
            // Llamada a la API para eliminar el producto
            await registerLog('DELETE', 'PEDIDOS', id);
            await pedidosAPI.deletePedido(id);
            alert("Pedido eliminado correctamente.");
            
            cargarPedidos()
    
        } catch (error) {
            alert("Error al eliminar el pedido. Inténtalo de nuevo.");
        }
    }


    async function createPedido() {
        const modalMostrar = document.querySelector(".modal-content");

        try{

            let createPedidoModalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="crearPedidoForm">
                        <label for="estado_pedido" class="form-label">Estado</label>
                        <select id="estado_pedido" name="estado_pedido" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Completado">Completado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>

                        <label for="id_user_pedido" class="form-label">Usuario ID</label>
                        <input type="number" class="form-control" id="id_user_pedido" name="id_user_pedido" required>

                        <label for="precio_pedido" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio_pedido" name="precio_pedido" step="0.01" required>

                        <label for="direccion_pedido" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion_pedido" name="direccion_pedido" required>

                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select id="metodo_pago" class="form-control" name="metodo_pago" required>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;

            modalMostrar.innerHTML = createPedidoModalHTML;

            const form = document.getElementById("crearPedidoForm");
            
            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                const formData = new FormData();
                formData.append("estado_pedido", form.estado_pedido.value);
                formData.append("id_user_pedido", form.id_user_pedido.value);
                formData.append("precio_pedido", parseFloat(form.precio_pedido.value));
                formData.append("direccion_pedido", form.direccion_pedido.value);
                formData.append("metodo_pago", form.metodo_pago.value);

                try {
                    const response = await pedidosAPI.createPedido(formData);
                    await registerLog('CREATE', 'PRODUCTOS', null);
                    if (response.success) {
                        alert("Pedido creado correctamente.");
                    } else {
                        alert(response.error || "Error al crear el pedido.");
                    }

                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();

                    // Recargar la tabla de pedidos
                    cargarPedidos();
                } catch (error) {
                    console.error("Error al crear el pedido:", error);
                    alert("Error al crear el pedido. Inténtalo de nuevo.");
                }
            });
        }
        catch(error){
            console.error("Error al crear el pedido:", error);
            modalMostrar.innerHTML = "<p>Error al crear el pedido. Inténtalo de nuevo más tarde.</p>";
        }
    }

    // USUARIOS
    
    function agregarEventosEditarUser() {
        const botonesEditar = document.querySelectorAll('.editar-user-btn');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idUser = e.currentTarget.getAttribute('data-id');
                editarUser(idUser);
            });
        });
    }

    function agregarEventosEliminarUser() {
        const botonesEliminar = document.querySelectorAll('.eliminar-user-btn');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', (e) => {
                const idUser = e.target.getAttribute('data-id');
                const confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");
                if (confirmar) {
                    deleteUser(idUser);
                }
            });
        });
    }

    function agregarEventosCreateUser() {
        const botonCreate = document.querySelector('.create-user-btn');
        botonCreate.addEventListener('click', () => {
            createUser();
        });
    }
    async function cargarUsuarios() {
        try {
            // Llamada a la API para obtener usuarios
            const usuarios = await userAPI.getUsers();

            // Construir la tabla con los datos
            const tablaHTML = `
                <button class="btn btn-primary btn-sm create-user-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear Usuario</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${usuarios.map(usuario => `
                            <tr>
                                <td>${usuario.id_user}</td>
                                <td>${usuario.nombre_user}</td>
                                <td>${usuario.apellidos_user}</td>
                                <td>${usuario.email_user}</td>
                                <td>${usuario.telefono_user}</td>
                                <td>${usuario.direction_user}</td>
                                <td>${usuario.admin_rol}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editar-user-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${usuario.id_user}">Editar</button>
                                    <button class="btn btn-danger btn-sm eliminar-user-btn" data-id="${usuario.id_user}">Eliminar</button>
                                </td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
            `;

            // Insertar la tabla en el contenedor
            tablaMostrar.innerHTML = tablaHTML;

            // Agregar eventos de clic a los botones "Editar"
            agregarEventosEditarUser();
            agregarEventosEliminarUser();
            agregarEventosCreateUser();


        } catch (error) {
            // Mostrar mensaje de error
            tablaMostrar.innerHTML = "<p>Error al cargar usuarios. Inténtalo de nuevo más tarde.</p>";
        }
    }

    async function editarUser(id){
        const modalMostrar = document.querySelector(".modal-content"); // Contenedor del modal
    
        try {
            // Obtener los detalles del usuario
            const user = await userAPI.getUserIndividual(id);
    
            // Construir el contenido del modal
            const modalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarUserForm">
                        <label for="nombre_user" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_user" name="nombre_user" value="${user.nombre_user}" required>
    
                        <label for="apellidos_user" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos_user" name="apellidos_user" value="${user.apellidos_user}" required>
    
                        <label for="contra_user" class="form-label">Nueva Contraseña (Opcional)</label>
                        <input type="password" class="form-control" id="contra_user" name="contra_user" placeholder="Dejar en blanco para no cambiar">
    
                        <label for="email_user" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email_user" name="email_user" value="${user.email_user}" required>
    
                        <label for="telefono_user" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_user" name="telefono_user" value="${user.telefono_user}" required>
    
                        <label for="direction_user" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direction_user" name="direction_user" value="${user.direction_user}" required>
    
                        <label for="admin_rol" class="form-label">Rol</label>
                        <select id="admin_rol" class="form-control" name="admin_rol" required>
                            <option value="0" ${user.admin_rol === 0 ? "selected" : ""}>Usuario</option>
                            <option value="1" ${user.admin_rol === 1 ? "selected" : ""}>Administrador</option>
                        </select>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;
    
            // Mostrar el formulario
            modalMostrar.innerHTML = modalHTML;
    
            // Manejar el envío del formulario
            const form = document.getElementById("editarUserForm");
            form.addEventListener("submit", async (event) => {
                event.preventDefault();
    
                // Construir el formulario de datos
                const formData = new FormData();
                formData.append("id_user", id);
                formData.append("nombre_user", form.nombre_user.value);
                formData.append("apellidos_user", form.apellidos_user.value);
                formData.append("email_user", form.email_user.value);
                formData.append("telefono_user", form.telefono_user.value);
                formData.append("direction_user", form.direction_user.value);
                formData.append("admin_rol", form.admin_rol.value);
    
                if (form.contra_user.value.trim() !== "") {
                    formData.append("contra_user", form.contra_user.value); // Enviar la contraseña directamente
                }
    
                try {
                    // Llamar a la API para editar el usuario
                    const response = await userAPI.updateUser(formData);
                    await registerLog('UPDATE', 'USERS', id);
    
                    if (response.success) {
                        alert("Usuario editado correctamente.");
                    } else {
                        alert(response.error || "Error al editar el usuario.");
                    }
    
                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
    
                    // Recargar la tabla de usuarios
                    cargarUsuarios();
                } catch (error) {
                    console.error("Error al editar el usuario:", error);
                    alert("Error al editar el usuario. Inténtalo de nuevo.");
                }
            });
    
        } catch (error) {
            console.error("Error al cargar el usuario:", error);
            modalMostrar.innerHTML = "<p>Error al cargar el usuario. Inténtalo de nuevo más tarde.</p>";
        }
    }
    


    async function createUser(){
        const modalMostrar = document.querySelector(".modal-content");

        try{

            let createUserModalHTML = `
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="crearUserForm">
                        <label for="nombre_user" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_user" name="nombre_user" required>

                        <label for="apellidos_user" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos_user" name="apellidos_user" required>

                        <label for="contra_user" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contra_user" name="contra_user" required>

                        <label for="email_user" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email_user" name="email_user" required>

                        <label for="telefono_user" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_user" name="telefono_user" required>

                        <label for="direction_user" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direction_user" name="direction_user" required>

                        <label for="admin_rol" class="form-label">Rol</label>
                        <select id="admin_rol" class="form-control" name="admin_rol" required>
                            <option value="0">Usuario</option>
                            <option value="1">Administrador</option>
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            `;

            modalMostrar.innerHTML = createUserModalHTML;

            const form = document.getElementById("crearUserForm");
            
            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                const formData = new FormData();
                formData.append("contra_user", form.contra_user.value);
                formData.append("nombre_user", form.nombre_user.value);
                formData.append("apellidos_user", form.apellidos_user.value);
                formData.append("email_user", form.email_user.value);
                formData.append("telefono_user", form.telefono_user.value);
                formData.append("direction_user", form.direction_user.value);
                formData.append("admin_rol", form.admin_rol.value);
                try {
                    const response = await userAPI.createUser(formData);
                    if (response.success) {
                        await registerLog('CREATE', 'USERS', null);

                        alert("Usuario creado correctamente.");
                    } else {
                        alert(response.error || "Error al crear el usuario.");
                    }

                    // Cerrar el modal
                    const modalElement = document.querySelector("#staticBackdrop");
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();

                    // Recargar la tabla de usuario
                    cargarUsuarios();
                } catch (error) {
                    console.error("Error al crear el usuario:", error);
                    alert("Error al crear el usuario. Inténtalo de nuevo.");
                }
            });
        }
        catch(error){
            console.error("Error al crear el usuario:", error);
            modalMostrar.innerHTML = "<p>Error al crear el usuario. Inténtalo de nuevo más tarde.</p>";
        }
    }

    async function deleteUser(id) {
        try {
            // Llamada a la API para eliminar el usuario
            await registerLog('DELETE', 'USERS', id);
            await userAPI.deleteUser(id);
            alert("Usuario eliminado correctamente.");
    
            // Recargar la tabla de usuarios
            cargarUsuarios();
    
        } catch (error) {
            alert("Error al eliminar el usuario. Inténtalo de nuevo.");
        }
    }

    async function cargarLogs() {
        try {
            const logs = await logsAPI.getLogs();
    
            // Ordenar los logs de mayor ID a menor ID
            logs.sort((a, b) => b.id_log - a.id_log);
    
            // Construir la tabla HTML
            const tablaHTML = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${logs.map(log => `
                            <tr>
                                <td>${log.id_log}</td>
                                <td>
                                    El usuario con ID <strong>${log.id_user_log}</strong> ha hecho <strong>${log.action_log}</strong> sobre la tabla <strong>${log.apartado_log}</strong>
                                    ${log.id_apartado_log !== 0 ? `, sobre el id <strong>${log.id_apartado_log}</strong>` : ''}
                                    ${log.fecha_log ? `. Fecha: ${log.fecha_log}` : ''}
                                </td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
            `;
    
            // Insertar la tabla en el contenedor
            tablaMostrar.innerHTML = tablaHTML;
    
        } catch (error) {
            // Mostrar mensaje de error
            tablaMostrar.innerHTML = "<p>Error al cargar logs. Inténtalo de nuevo más tarde.</p>";
        }
    }
    

    async function registerLog(action, apartado, idApartado) {
        const idUser = sessionUser; // Obtener el ID del usuario desde sessionStorage
        if (!idUser) {
            alert("Usuario no autenticado. No se puede registrar el log.");
            return;
        }
    
         // Crear el objeto con la información del log
        const logData = {
            id_user_log: idUser, // ID del usuario desde sessionStorage
            action_log: action, // Acción realizada (como 'CREATE', 'DELETE', etc.)
            apartado_log: apartado, // Apartado donde se realiza la acción (por ejemplo, 'USERS')
            id_apartado_log: idApartado, // ID del apartado afectado (como ID de usuario, ID de producto, etc.)
        };

        try {
            // Realizar la llamada a la API para registrar el log
            const response = await fetch('?url=api&action=insert-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(logData), // Enviar los datos como JSON
            });

        } catch (error) {
            console.error('Error en la solicitud de registro de log:', error); // Manejo de errores
        }
    }

    // Cargar productos al iniciar
    cargarProductos();
});
