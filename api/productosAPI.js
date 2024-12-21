class ProductosAPI {
    constructor(navLinksSelector, contentContainerSelector) {
        this.navLinks = document.querySelectorAll(navLinksSelector);
        this.contentContainer = document.querySelector(contentContainerSelector);

        this.init();
    }

    init() {
        this.navLinks.forEach(link => {
            link.addEventListener("click", async (event) => {
                event.preventDefault();

                const section = link.getAttribute("data-section");
                if (section === "productos") {
                    try {
                        const productos = await this.fetchProductos();
                        this.renderProductosTable(productos);
                    } catch (error) {
                        console.error("Error al obtener los productos:", error);
                        this.contentContainer.innerHTML = "<p>Error al cargar los productos</p>";
                    }
                }
            });
        });
    }

    async fetchProductos() {
        const response = await fetch("?url=admin/productos");
        if (!response.ok) {
            throw new Error("Error al obtener los productos");
        }
        return await response.json();
    }

    renderProductosTable(productos) {
        if (!Array.isArray(productos) || productos.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay productos disponibles</p>";
            return;
        }
    
        const table = document.createElement("table");
        table.classList.add("table", "table-striped");
    
        const thead = document.createElement("thead");
        thead.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>                
            </tr>
        `;
    
        const tbody = document.createElement("tbody");
    
        productos.forEach(producto => {
            const row = document.createElement("tr");
    
            row.innerHTML = `
                <td>${producto.id_producto || ""}</td>
                <td>
                    ${producto.foto_producto ? `<img src="${producto.foto_producto}" alt="${producto.nombre_producto}" style="width: 50px; height: 50px;">` : "N/A"}
                </td>
                <td>${producto.nombre_producto || ""}</td>
                <td>${producto.descripcion_producto || ""}</td>
                <td>${producto.precio_producto || ""}</td>
                <td>${producto.stock_producto || ""}</td>   
            `;
    
            tbody.appendChild(row);
        });
    
        table.appendChild(thead);
        table.appendChild(tbody);
    
        this.contentContainer.innerHTML = "";
        this.contentContainer.appendChild(table);
    }    
}

// Inicializa la clase cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    new ProductosAPI(".nav-link", "#content-container");
});
