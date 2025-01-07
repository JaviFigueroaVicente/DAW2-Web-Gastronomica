export class ProductosAPI {
    // Constructor que recibe la URL base para las solicitudes de la API
    constructor(baseUrl) {
        this.baseUrl = baseUrl; // Guarda la URL base
    }

    // Método para obtener todos los productos
    async getProductos() {
        try {
            // Realiza una solicitud GET para obtener los productos
            const response = await fetch(`${this.baseUrl}&action=productos`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('No se pudieron obtener los productos');
            }

            // Convierte la respuesta a JSON y la devuelve
            const data = await response.json();
            return data;
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola y devuelve un arreglo vacío
            console.error(error);
            return []; // Retorna un arreglo vacío en caso de error
        }
    }

    // Método para obtener un producto específico por su ID
    async getProductoIndividual(id) {
        try {
            // Realiza una solicitud GET para obtener un producto específico
            const response = await fetch(`${this.baseUrl}&action=producto-individual&id=${id}`);
            
            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al obtener el producto');
            }

            // Convierte la respuesta JSON
            const data = await response.json();

            // Si no se encuentra el producto, lanza un error
            if (!data) {
                throw new Error('Producto no encontrado');
            }

            return data; // Devuelve el producto encontrado
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola y devuelve null
            console.error("Error al obtener el producto:", error);
            return null; // Retorna null si no se encuentra el producto o hay un error
        }
    }

    // Método para actualizar un producto
    async updateProducto(producto) {
        try {
            let body;

            // Si el producto incluye un archivo (por ejemplo, una imagen), usa FormData
            if (producto instanceof FormData) {
                body = producto;
            } else {
                // Si no es FormData, convierte el producto a formato JSON
                body = JSON.stringify(producto);
            }

            // Realiza una solicitud POST para actualizar el producto
            const response = await fetch(`${this.baseUrl}&action=update-producto`, {
                method: 'POST', // Método POST para enviar los datos del producto
                body: body, // Envía los datos como FormData o JSON
                headers: producto instanceof FormData ? undefined : {
                    'Content-Type': 'application/json' // Si no es FormData, establece el encabezado como JSON
                }
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al actualizar el producto');
            }

            // Devuelve la respuesta como JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola y lanza el error
            console.error("Error al actualizar el producto:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para eliminar un producto
    async deleteProducto(producto) {
        try {
            // Realiza una solicitud DELETE para eliminar un producto
            const response = await fetch(`${this.baseUrl}&action=delete-producto`, {
                method: 'DELETE', // Método DELETE para eliminar el producto
                headers: {
                    'Content-Type': 'application/json' // El tipo de contenido es JSON
                },
                body: JSON.stringify({ id_producto: producto }) // Envía el ID del producto como JSON
            });

            // Si la respuesta no es exitosa, lanza un error con el mensaje de error
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el producto');
            }

            // Devuelve los datos de la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola y lanza el error
            console.error("Error al eliminar el producto:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }

    // Método para crear un nuevo producto
    async createProducto(formData) {
        try {
            // Realiza una solicitud POST para crear un nuevo producto
            const response = await fetch(`${this.baseUrl}&action=create-producto`, {
                method: 'POST', // Método POST para crear el producto
                body: formData // FormData contiene automáticamente los encabezados necesarios
            });

            // Si la respuesta no es exitosa, lanza un error
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }

            // Devuelve los datos de la respuesta en formato JSON
            return await response.json();
        } catch (error) {
            // Si ocurre un error, lo muestra en la consola y lanza el error
            console.error("Error al crear el producto:", error);
            throw error; // Lanza el error para que se maneje en el lugar donde se llama
        }
    }
}
