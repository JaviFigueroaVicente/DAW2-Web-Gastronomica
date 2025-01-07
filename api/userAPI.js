export class UserAPI {
    // Constructor que recibe la URL base para las solicitudes de la API
    constructor(baseUrl) {
        this.baseUrl = baseUrl; // Guarda la URL base
    }

    // Método para obtener todos los usuarios
    async getUsers() {
        try {
            // Realiza una solicitud GET a la URL con el parámetro 'action=users'
            const response = await fetch(`${this.baseUrl}&action=users`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('No se pudieron obtener los usuarios');
            }

            // Convierte la respuesta a JSON y la devuelve
            const data = await response.json();
            return data;
        } catch (error) {
            // Si ocurre un error (en la solicitud o en el procesamiento de datos), lo muestra en la consola
            console.error(error);
            return []; // Devuelve un arreglo vacío en caso de error
        }
    }

    // Método para obtener un usuario específico por su ID
    async getUserIndividual(id) {
        try {
            // Realiza una solicitud GET a la URL con el parámetro 'action=user-individual' y el ID del usuario
            const response = await fetch(`${this.baseUrl}&action=user-individual&id=${id}`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al obtener el usuario');
            }

            // Convierte la respuesta JSON
            const data = await response.json();

            // Si no se encuentra el usuario, lanza un error
            if (!data) {
                throw new Error('Usuario no encontrado');
            }

            return data; // Devuelve el usuario encontrado
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al obtener el usuario:", error);
            return null; // Devuelve null si el usuario no se encuentra o si hay un error
        }
    }

    // Método para actualizar un usuario
    async updateUser(user) {
        try {
            let body;

            // Si 'user' es una instancia de FormData, se usa tal cual
            if (user instanceof FormData) {
                body = user;
            } else {
                // Si no es FormData, convierte los datos a JSON
                body = JSON.stringify(user);
            }

            // Realiza una solicitud POST para actualizar el usuario
            const response = await fetch(`${this.baseUrl}&action=update-user`, {
                method: 'POST', // Método POST para permitir actualizaciones
                body: body, // Envía los datos del usuario (como FormData o JSON)
                headers: user instanceof FormData ? undefined : {
                    'Content-Type': 'application/json' // Si no es FormData, establece el tipo de contenido como JSON
                }
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al actualizar el usuario');
            }

            // Devuelve los datos de la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al actualizar el usuario:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para crear un nuevo usuario
    async createUser(formData) {
        try {
            // Realiza una solicitud POST para crear un nuevo usuario
            const response = await fetch(`${this.baseUrl}&action=create-user`, {
                method: 'POST', // Método POST para crear el usuario
                body: formData // FormData contiene automáticamente los encabezados necesarios
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al crear el usuario');
            }

            // Devuelve los datos de la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al crear el usuario:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para eliminar un usuario
    async deleteUser(user) {
        try {
            // Realiza una solicitud DELETE para eliminar un usuario
            const response = await fetch(`${this.baseUrl}&action=delete-user`, {
                method: 'DELETE', // Método DELETE para eliminar el usuario
                headers: {
                    'Content-Type': 'application/json' // El tipo de contenido es JSON
                },
                body: JSON.stringify({ id_user: user }) // Envía el ID del usuario como parte del cuerpo de la solicitud
            });

            // Si la respuesta no es exitosa, lanza un error con el mensaje
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el usuario');
            }

            // Devuelve los datos de la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al eliminar el usuario:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }
}
