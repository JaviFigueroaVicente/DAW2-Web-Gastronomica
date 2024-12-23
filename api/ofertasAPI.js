export class OfertasAPI {
    constructor(contentContainer) {
        this.contentContainer = contentContainer;
    }

    async load() {
        const response = await fetch("?url=admin/ofertas"); 
        if (!response.ok) throw new Error("Error al obtener ofertas");

        const ofertas = await response.json();
        this.render(ofertas);
    }

    render(ofertas) {
        if (ofertas.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay ofertas disponibles</p>";
            return;
        }

        const table = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Descuento</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    ${ofertas.map(oferta => `
                        <tr>
                            <td>${oferta.id_oferta}</td>
                            <td>${oferta.nombre_oferta}</td>
                            <td>${oferta.descripcion_oferta}</td>
                            <td>${oferta.descuento_oferta}</td>
                            <td>${oferta.fecha_inicio_oferta}</td>
                            <td>${oferta.fecha_fin_oferta}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editarOferta(${oferta.id_oferta})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarOferta(${oferta.id_oferta})">Eliminar</button>
                            </td>
                        </tr>`).join('')}
                </tbody>
            </table>
        `;

        this.contentContainer.innerHTML = table;
    }
}
