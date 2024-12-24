import { ProductosAPI } from "./productosAPI.js";

document.addEventListener("DOMContentLoaded", () => {
    const productosAPI = new ProductosAPI('?url=api'); // Define la URL base de tu API
    const radioProductos = document.getElementById("vbtn-radio1");
    const tablaMostrar = document.getElementById("tabla-mostrar"); // Contenedor donde mostrar la tabla

    radioProductos.addEventListener("change", async () => {
        if (radioProductos.checked) {
            try {
                // Llamada a la API para obtener productos
                const productos = await productosAPI.getProductos();

                // Construir la tabla con los datos
                let tablaHTML = `
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
                                <button class="btn btn-warning btn-sm editar-btn" data-id="${producto.id_producto}">Editar</button>
                            </td>
                        </tr>
                    `;
                });

                tablaHTML += `</tbody></table>`;

                // Insertar la tabla en el contenedor
                tablaMostrar.innerHTML = tablaHTML;

                // Agregar eventos de clic a los botones "Editar"
                const botonesEditar = document.querySelectorAll('.editar-btn');
                botonesEditar.forEach(boton => {
                    boton.addEventListener('click', async (e) => {
                        const idProducto = e.target.getAttribute('data-id');
                        editarProducto(idProducto); // Llamada a la función editarProducto
                    });
                });

            } catch (error) {
                // Mostrar mensaje de error
                tablaMostrar.innerHTML = "<p>Error al cargar productos. Inténtalo de nuevo más tarde.</p>";
            }
        }
    });

    // Función para editar un producto
    async function editarProducto(id) {
        const productosAPI = new ProductosAPI('?url=api'); // URL base de la API
        const tablaMostrar = document.getElementById("tabla-mostrar"); // Contenedor de la tabla
    
        try {
            // Llamada a la API para obtener los detalles del producto individual
            const producto = await productosAPI.getProductoIndividual(id);
    
            // Construir la tabla con los datos del producto
            let tablaHTML = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${producto.id_producto}</td>
                            <td>${producto.nombre_producto}</td>
                            <td>${producto.descripcion_producto}</td>
                            <td>${producto.precio_producto}</td>
                            <td>${producto.stock_producto}</td>
                            <td>
                                ${
                                    producto.foto_producto
                                        ? `<img src="${producto.foto_producto}" alt="Imagen de ${producto.nombre_producto}" style="width: 100px; height: 100px; object-fit: cover;">`
                                        : "Sin imagen"
                                }
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form>
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" value="${producto.nombre_producto}" />
                    
                    <label for="descripcion">Descripción</label>
                    <input type="text" id="descripcion" value="${producto.descripcion_producto}" />
                    
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" value="${producto.precio_producto}" />
                    
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" value="${producto.stock_producto}" />
                    
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            `;
    
            // Mostrar los detalles del producto y formulario de edición
            tablaMostrar.innerHTML = tablaHTML;
    
        } catch (error) {
            // Mostrar mensaje de error
            tablaMostrar.innerHTML = "<p>Error al cargar el producto. Inténtalo de nuevo más tarde.</p>";
        }
    }
});
