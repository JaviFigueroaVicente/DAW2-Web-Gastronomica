export class PedidosAPI {
    // Constructor que recibe la URL base para realizar las solicitudes a la API
    constructor(baseUrl) {
        this.baseUrl = baseUrl; // Guarda la URL base proporcionada
    }

    // Método para obtener todos los pedidos
    async getPedidos() {
        try {
            // Realiza una solicitud GET a la URL con el parámetro 'action=pedidos'
            const response = await fetch(`${this.baseUrl}&action=pedidos`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('No se pudieron obtener los pedidos');
            }

            // Convierte la respuesta JSON y la devuelve
            const data = await response.json();
            return data;
        } catch (error) {
            // Si ocurre un error (en la solicitud o al obtener los datos), lo muestra en la consola
            console.error(error);
            return []; // Devuelve un arreglo vacío en caso de error
        }
    }

    // Método para obtener un pedido individual por su ID
    async getPedidoIndividual(id) {
        try {
            // Realiza una solicitud GET con el parámetro 'action=pedido-individual' y el ID del pedido
            const response = await fetch(`${this.baseUrl}&action=pedido-individual&id=${id}`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al obtener el pedido');
            }

            // Convierte la respuesta JSON
            const data = await response.json();

            // Si no se encuentran datos, lanza un error
            if (!data) {
                throw new Error('Pedido no encontrado');
            }

            return data; // Devuelve el pedido individual
        } catch (error) {
            // Muestra el error en la consola si ocurre
            console.error("Error al obtener el pedido:", error);
            return null; // Devuelve null en caso de error
        }
    }

    // Método para actualizar un pedido
    async updatePedido(pedido) {
        try {
            let body;

            // Si 'pedido' es una instancia de FormData, se usa tal cual, sino se convierte a JSON
            if(pedido instanceof FormData) {
                body = pedido;
            } else {
                body = JSON.stringify(pedido);
            }

            // Realiza una solicitud POST con los datos del pedido a la URL con 'action=update-pedido'
            const response = await fetch(`${this.baseUrl}&action=update-pedido`, {
                method: 'POST', // Método POST
                body: body, // Datos del pedido
                headers: pedido instanceof FormData ? undefined : {
                    'Content-Type': 'application/json' // Si no es FormData, establece el tipo de contenido como JSON
                },
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al actualizar el pedido');
            }

            // Devuelve los datos de la respuesta
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al actualizar el pedido:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para eliminar un pedido
    async deletePedido(id) {
        try {
            // Realiza una solicitud DELETE para eliminar un pedido por su ID
            const response = await fetch(`${this.baseUrl}&action=delete-pedido`, {
                method: 'DELETE', // Método DELETE
                headers: {
                    'Content-Type': 'application/json' // Tipo de contenido en JSON
                },
                body: JSON.stringify({ id_pedido: id }) // Envía el ID del pedido como cuerpo de la solicitud
            });

            // Si la respuesta no es exitosa, lanza un error con un mensaje
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el pedido');
            }

            // Devuelve la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al eliminar el pedido:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para crear un nuevo pedido
    async createPedido(pedido) {
        try {
            // Realiza una solicitud POST para crear un nuevo pedido
            const response = await fetch(`${this.baseUrl}&action=create-pedido`, {
                method: 'POST', // Método POST
                body: pedido // Envía los datos del nuevo pedido
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al crear el pedido');
            }

            // Devuelve la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola
            console.error("Error al crear el pedido:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }
}
