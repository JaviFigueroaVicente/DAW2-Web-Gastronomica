import { ProductosAPI } from "./productosAPI.js";
import { PedidosAPI } from "./pedidosAPI.js";
import { UserAPI } from "./userAPI.js";

document.addEventListener("DOMContentLoaded", () => {
    const productosAPI = new ProductosAPI('?url=api');
    const pedidosAPI = new PedidosAPI('?url=api'); 
    const userAPI = new UserAPI('?url=api');// Define la URL base de tu API
    const radioProductos = document.getElementById("vbtn-radio1");
    const radioPedidos= document.getElementById("vbtn-radio2");
    const radioUsuarios = document.getElementById("vbtn-radio3");
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
                                <td>${producto.precio_producto}</td>
                                <td>${producto.stock_producto}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm editar-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${producto.id_producto}">Editar</button>
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
    
            // Definir las columnas de forma dinámica
            const columnas = [
                { key: "id_pedido", label: "ID Pedido" },
                { key: "fecha_pedido", label: "Fecha Pedido" },
                { key: "estado_pedido", label: "Estado" },
                { key: "id_user_pedido", label: "Cliente" },
                { key: "precio_pedido", label: "Precio" },
                { key: "direccion_pedido", label: "Dirección" },
                { key: "metodo_pago", label: "Método de Pago" },
            ];
    
            // Construir la tabla HTML
            let tablaHTML = `
                <button class="btn btn-primary btn-sm create-pedido-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear Pedido</button>
                <table class="table">
                    <thead>
                        <tr>
                            ${columnas.map(col => `<th>${col.label}</th>`).join('')}
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
    
            pedidos.forEach(pedido => {
                tablaHTML += `
                    <tr>
                        ${columnas.map(col => `<td>${pedido[col.key] ?? (col.key === "id_oferta_" ? 0 : "")}</td>`).join('')}
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
                        
                        <label for="fecha_pedido">Fecha del Pedido</label>
                        <input type="datetime-local" id="fecha_pedido" name="fecha_pedido" 
                            value="${new Date(pedido.fecha_pedido).toISOString().slice(0, 16)}" required>
                        
                        <label for="estado_pedido">Estado</label>
                        <select id="estado_pedido" name="estado_pedido" required>
                            <option value="Pendiente" ${pedido.estado_pedido === "Pendiente" ? "selected" : ""}>Pendiente</option>
                            <option value="En Proceso" ${pedido.estado_pedido === "En Proceso" ? "selected" : ""}>En Proceso</option>
                            <option value="Completado" ${pedido.estado_pedido === "Completado" ? "selected" : ""}>Completado</option>
                            <option value="Cancelado" ${pedido.estado_pedido === "Cancelado" ? "selected" : ""}>Cancelado</option>
                        </select>
    
                        <label for="id_user_pedido">Usuario ID</label>
                        <input type="number" id="id_user_pedido" name="id_user_pedido" 
                            value="${pedido.id_user_pedido}" required>
                        
                        <label for="precio_pedido">Precio</label>
                        <input type="number" id="precio_pedido" name="precio_pedido" 
                            value="${pedido.precio_pedido}" step="0.01" required>
                        
                        <label for="direccion_pedido">Dirección</label>
                        <input type="text" id="direccion_pedido" name="direccion_pedido" 
                            value="${pedido.direccion_pedido}" required>
                        
                        <label for="metodo_pago">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" required>
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
                        <label for="estado_pedido">Estado</label>
                        <select id="estado_pedido" name="estado_pedido" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Completado">Completado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>

                        <label for="id_user_pedido">Usuario ID</label>
                        <input type="number" id="id_user_pedido" name="id_user_pedido" required>

                        <label for="precio_pedido">Precio</label>
                        <input type="number" id="precio_pedido" name="precio_pedido" step="0.01" required>

                        <label for="direccion_pedido">Dirección</label>
                        <input type="text" id="direccion_pedido" name="direccion_pedido" required>

                        <label for="metodo_pago">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" required>
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
                                    <button class="btn btn-warning btn-sm editar-user-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="${usuario.id_user}">Editar</button>
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
                        <label for="nombre_user">Nombre</label>
                        <input type="text" id="nombre_user" name="nombre_user" value="${user.nombre_user}" required>
    
                        <label for="apellidos_user">Apellidos</label>
                        <input type="text" id="apellidos_user" name="apellidos_user" value="${user.apellidos_user}" required>
    
                        <label for="contra_user">Nueva Contraseña (Opcional)</label>
                        <input type="password" id="contra_user" name="contra_user" placeholder="Dejar en blanco para no cambiar">
    
                        <label for="email_user">Correo</label>
                        <input type="email" id="email_user" name="email_user" value="${user.email_user}" required>
    
                        <label for="telefono_user">Teléfono</label>
                        <input type="text" id="telefono_user" name="telefono_user" value="${user.telefono_user}" required>
    
                        <label for="direction_user">Dirección</label>
                        <input type="text" id="direction_user" name="direction_user" value="${user.direction_user}" required>
    
                        <label for="admin_rol">Rol</label>
                        <select id="admin_rol" name="admin_rol" required>
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
                        <label for="nombre_user">Nombre</label>
                        <input type="text" id="nombre_user" name="nombre_user" required>

                        <label for="apellidos_user">Apellidos</label>
                        <input type="text" id="apellidos_user" name="apellidos_user" required>

                        <label for="contra_user">Contraseña</label>
                        <input type="password" id="contra_user" name="contra_user" required>

                        <label for="email_user">Correo</label>
                        <input type="email" id="email_user" name="email_user" required>

                        <label for="telefono_user">Teléfono</label>
                        <input type="text" id="telefono_user" name="telefono_user" required>

                        <label for="direction_user">Dirección</label>
                        <input type="text" id="direction_user" name="direction_user" required>

                        <label for="admin_rol">Rol</label>
                        <select id="admin_rol" name="admin_rol" required>
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
            await userAPI.deleteUser(id);
            alert("Usuario eliminado correctamente.");
    
            // Recargar la tabla de usuarios
            cargarUsuarios();
    
        } catch (error) {
            alert("Error al eliminar el usuario. Inténtalo de nuevo.");
        }
    }

    // Cargar productos al iniciar
    cargarProductos();
});
