class UserAPI {
    constructor(navLinksSelector, contentContainerSelector) {
        this.navLinks = document.querySelectorAll(navLinksSelector);
        this.contentContainer = document.querySelector(contentContainerSelector);

        this.init();
    }

    // Inicializa los eventos de los enlaces
    init() {
        this.navLinks.forEach(link => {
            link.addEventListener("click", async (event) => {
                event.preventDefault();

                const section = link.getAttribute("data-section");
                if (section === "usuarios") {
                    try {
                        const users = await this.fetchUsers();
                        this.renderUserTable(users);
                    } catch (error) {
                        console.error("Error al obtener los usuarios:", error);
                        this.contentContainer.innerHTML = "<p>Error al cargar usuarios</p>";
                    }
                }
            });
        });
    }

    // Realiza una petición para obtener los usuarios
    async fetchUsers() {
        const response = await fetch("?url=admin/users");
        if (!response.ok) {
            throw new Error("Error al obtener los usuarios");
        }
        return await response.json();
    }

    // Renderiza la tabla de usuarios
    renderUserTable(users) {
        if (!Array.isArray(users) || users.length === 0) {
            this.contentContainer.innerHTML = "<p>No hay usuarios disponibles</p>";
            return;
        }

        const table = document.createElement("table");
        table.classList.add("table", "table-striped");

        const thead = document.createElement("thead");
        thead.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Rol de Admin</th>
            </tr>
        `;

        const tbody = document.createElement("tbody");

        users.forEach(user => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${user.id_user || ""}</td>
                <td>${user.email || ""}</td>
                <td>${user.nombre || ""}</td>
                <td>${user.apellidos || "N/A"}</td>
                <td>${user.telefono || "N/A"}</td>
                <td>${user.direction || "N/A"}</td>
                <td>${user.admin || ""}</td>
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
    new UserAPI(".nav-link", "#content-container");
});