export class LogsAPI { 
    // Constructor que recibe la URL base para las solicitudes a la API
    constructor(baseUrl) {
        this.baseUrl = baseUrl; // Guarda la URL base proporcionada
    }

    // Método para obtener los logs desde la API
    async getLogs() {
        try {
            // Realiza la solicitud GET agregando el parámetro 'action=logs' a la URL
            const response = await fetch(`${this.baseUrl}&action=logs`);
            
            // Si la respuesta no es exitosa (status no ok), lanza un error con el código y mensaje
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            
            // Convierte la respuesta JSON y la devuelve
            const data = await response.json();
            return data;
        } catch (error) {
            // Si ocurre un error (en la solicitud o al obtener los datos), muestra el error en la consola
            console.error("Error fetching logs:", error);
            return []; // Devuelve un arreglo vacío en caso de error
        }
    }

    // Método para insertar logs en la API
    async insertLogs() {
        try {
            // Realiza la solicitud GET agregando el parámetro 'action=insert-logs' a la URL
            const response = await fetch(`${this.baseUrl}&action=insert-logs`);
            
            // Si la respuesta no es exitosa (status no ok), lanza un error con el código y mensaje
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            
            // Convierte la respuesta JSON y la devuelve
            const data = await response.json();
            return data;
        } catch (error) {
            // Si ocurre un error (en la solicitud o al obtener los datos), muestra el error en la consola
            console.error("Error fetching logs:", error);
            return []; // Devuelve un arreglo vacío en caso de error
        }
    }
}
