export class ProductosAPI {
    constructor(contentContainer) {
        this.contentContainer = contentContainer;
    }

    async load() {
        const response = await fetch("?url=admin/productos"); 
        if (!response.ok) throw new Error("Error al obtener productos");

        const productos = await response.json();
        this.render(productos);
    }

    render(productos) {
        if (productos.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay productos disponibles</p>";
            return;
        }

        const table = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
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
                            <td>${producto.foto_producto ? `<img src="${producto.foto_producto}" style="width:50px;height:50px;">` : "N/A"}</td>
                            <td>${producto.nombre_producto}</td>
                            <td>${producto.descripcion_producto}</td>
                            <td>${producto.precio_producto} €</td>
                            <td>${producto.stock_producto}</td>
                            <td>
                            <button class="btn btn-primary btn-edit" data-id="${producto.id_producto}" data-bs-toggle="modal" data-bs-target="#editModal">
                                Editar
                            </button>
                            </td>
                        </tr>`).join('')}
                </tbody>
            </table>
        `;

        this.contentContainer.innerHTML = table;

        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const productId = e.target.dataset.id;
                this.loadEditModal(productId);
            });
        });
    }
}
