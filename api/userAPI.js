export class UserAPI {
    constructor(contentContainer) {
        this.contentContainer = contentContainer;
    }

    async load() {
        const response = await fetch("?url=admin/users"); 
        if (!response.ok) throw new Error("Error al obtener usuarios");

        const users = await response.json();
        this.render(users);
    }

    render(users) {
        if (users.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay usuarios disponibles</p>";
            return;
        }

        const table = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    ${users.map(user => `
                        <tr>
                            <td>${user.id_user}</td>
                            <td>${user.nombre}</td>
                            <td>${user.apellidos}</td>
                            <td>${user.email}</td>
                            <td>${user.telefono}</td>
                            <td>${user.direction}</td>
                            <td>${user.admin}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>`).join('')}
                </tbody>
            </table>
        `;

        this.contentContainer.innerHTML = table;
    }

}
