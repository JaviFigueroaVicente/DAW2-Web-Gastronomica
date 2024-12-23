export class PedidosAPI {
    constructor(contentContainer) {
        this.contentContainer = contentContainer;
    }

    async load() {
        const response = await fetch("?url=admin/pedidos");
        if (!response.ok) throw new Error("Error al obtener pedidos");

        const pedidos = await response.json();
        this.render(pedidos);
    }

    render(pedidos) {
        if (pedidos.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay pedidos disponibles</p>";
            return;
        }

        const table = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Dirección</th>
                        <th>Metodo Pago</th>
                        <th>ID Oferta<th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    ${pedidos.map(pedido => `
                        <tr>
                            <td>${pedido.id_pedido}</td>
                            <td>${pedido.fecha_pedido}</td>
                            <td>${pedido.estado_pedido}</td>
                            <td>${pedido.id_user_pedido}</td>
                            <td>${pedido.precio_pedido} €</td>
                            <td>${pedido.direccion_pedido}</td>
                            <td>${pedido.metodo_pago}</td>
                            <td>${pedido.id_oferta_}</td>
                            <td>
                                <button class="btn btn-primary" onclick="verPedido(${pedido.id_pedido})">Ver</button>
                                <button class="btn btn-danger" onclick="eliminarPedido(${pedido.id_pedido})">Eliminar</button>
                            </td>
                        </tr>`).join('')}
                </tbody>
            </table>
        `;

        this.contentContainer.innerHTML = table;
    }
    
    async verPedido(id_pedido) {
        const response = await fetch(`?url=admin/pedidos/${id_pedido}`);
        if (!response.ok) throw new Error("Error al obtener pedido");

        const pedido = await response.json();
        this.render(pedido);
    }
}