import { ProductosAPI } from "./productosAPI.js";
import { PedidosAPI } from "./pedidosAPI.js";

document.addEventListener("DOMContentLoaded", () => {
    const productosAPI = new ProductosAPI('?url=api');
    const pedidosAPI = new PedidosAPI('?url=api'); // Define la URL base de tu API
    const radioProductos = document.getElementById("vbtn-radio1");
    const radioPedidos= document.getElementById("vbtn-radio2");
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

    async function cargarProductos() {
        try {
            // Llamada a la API para obtener productos
            const productos = await productosAPI.getProductos();

            // Construir la tabla con los datos
            let tablaHTML = `
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            productos.forEach(producto => {
                tablaHTML += `
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
                        <td>${producto.precio_producto}</td>
                        <td>${producto.stock_producto}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editar-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${producto.id_producto}">Editar</button>
                            <button class="btn btn-danger btn-sm eliminar-btn" data-id="${producto.id_producto}">Eliminar</button>    
                        </td>
                    </tr>
                `;
            });

            tablaHTML += `</tbody></table>`;

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
                    <form id="editarProductoForm">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="${producto.nombre_producto}" required>
                        
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" value="${producto.descripcion_producto}" required>
                        
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" value="${producto.precio_producto}" step="0.01" required>
                        
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" value="${producto.stock_producto}" min="0" required>
                        
                        <label for="foto_producto">Actualizar Imagen (Opcional)</label>
                        <input type="file" id="foto_producto" name="foto_producto" accept="image/*">
    
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
                formData.append("stock_producto", parseInt(form.stock.value, 10));
    
                // Agregar la imagen si fue seleccionada
                if (form.foto_producto.files.length > 0) {
                    formData.append("foto_producto", form.foto_producto.files[0]);
                }
    
                try {
                    // Enviar datos al servidor
                    await productosAPI.updateProducto(formData);
                    alert("Producto actualizado correctamente.");
    
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
                    <form id="crearProductoForm">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
    
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" required>
    
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" step="0.01" required>
    
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" required>
    
                        <label for="id_categoria_producto">ID Categoría</label>
                        <input type="number" id="id_categoria_producto" name="id_categoria_producto" min="1" required>
    
                        <label for="foto_producto">Imagen</label>
                        <input type="file" id="foto_producto" name="foto_producto" accept="image/*" required>
    
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

            let tablaHTML = `
                <button class="btn btn-primary btn-sm create-pedido-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear Pedido</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha Pedido</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Precio</th>
                            <th>Dirección</th>
                            <th>Método de Pago</th>
                            <th>Id Oferta</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            pedidos.forEach(pedido => {
                tablaHTML += `
                    <tr>
                        <td>${pedido.id_pedido}</td>
                        <td>${pedido.fecha_pedido}</td>
                        <td>${pedido.estado_pedido}</td>
                        <td>${pedido.id_user_pedido}</td>
                        <td>${pedido.precio_pedido}</td>
                        <td>${pedido.direccion_pedido}</td>
                        <td>${pedido.metodo_pago}</td>
                        <td>${pedido.id_oferta_}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editar-pedido-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${pedido.id_pedido}">Editar</button>
                            <button class="btn btn-danger btn-sm eliminar-pedido-btn" data-id="${pedido.id_pedido}">Eliminar</button>    
                        </td>
                    </tr>
                `;
            });

            tablaHTML += `</tbody></table>`;
            tablaMostrar.innerHTML = tablaHTML;

            agregarEventosEditarPedidos();
            agregarEventosEliminarPedidos();
            agregarEventosCreatePedidos();

        } catch (error) {
            tablaMostrar.innerHTML = "<p>Error al cargar pedidos. Inténtalo de nuevo más tarde.</p>";
        }
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
        // Implementar edición de pedido similar a editarProducto
    }

    async function deletePedido(id) {
        try {
            await pedidosAPI.deletePedido(id);
            alert("Pedido eliminado correctamente.");
            cargarPedidos();
        } catch (error) {
            alert("Error al eliminar el pedido. Inténtalo de nuevo.");
        }
    }

    async function createPedido() {
        // Implementar creación de pedido similar a createProducto
    }

    
    
    // Cargar productos al iniciar
    cargarProductos();
});
