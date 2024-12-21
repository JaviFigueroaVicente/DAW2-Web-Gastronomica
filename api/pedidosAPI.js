class PedidosAPI {
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
                if (section === "pedidos") {
                    try {
                        const pedidos = await this.fetchPedidos();
                        this.renderPedidosTable(pedidos);
                    } catch (error) {
                        console.error("Error al obtener los pedidos:", error);
                        this.contentContainer.innerHTML = "<p>Error al cargar los pedidos</p>";
                    }
                }
            });
        });
    }

    async fetchPedidos() {
        const response = await fetch("?url=admin/pedidos");
        if (!response.ok) {
            throw new Error("Error al obtener los pedidos");
        }
        return await response.json();
    }

    renderPedidosTable(pedidos) {
        if (!Array.isArray(pedidos) || pedidos.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay pedidos disponibles</p>";
            return;
        }

        const table = document.createElement("table");
        table.classList.add("table", "table-striped");

        const thead = document.createElement("thead");
        thead.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>ID usuario</th>
                <th>Precio</th>
                <th>Dirección</th>
                <th>Método de pago</th>
                <th>ID oferta</th>
            </tr>
        `;

        const tbody = document.createElement("tbody");

        pedidos.forEach(pedido => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${pedido.id_pedido || ""}</td>
                <td>${pedido.fecha_pedido || ""}</td>
                <td>${pedido.estado_pedido || ""}</td>
                <td>${pedido.id_user_pedido || ""}</td>
                <td>${pedido.precio_pedido || ""}</td>
                <td>${pedido.direccion_pedido || ""}</td>
                <td>${pedido.metodo_pago || ""}</td>
                <td>${pedido.id_oferta_ || ""}</td>
            `;

            tbody.appendChild(row);
        });

        table.appendChild(thead);
        table.appendChild(tbody);

        this.contentContainer.innerHTML = "";
        this.contentContainer.appendChild(table);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new PedidosAPI(".nav-link", "#content-container");
});
