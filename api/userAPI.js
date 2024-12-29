export class UserAPI {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async getUsers(){
        try {
            const response = await fetch(`${this.baseUrl}&action=users`);
            if (!response.ok) {
                throw new Error('No se pudieron obtener los usuarios');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error(error);
            return [];
        }
    }

    async getUserIndividual(id){
        try {
            const response = await fetch(`${this.baseUrl}&action=user-individual&id=${id}`);
            if (!response.ok) {
                throw new Error('Error al obtener el usuario');
            }

            const data = await response.json();
            if (!data) {
                throw new Error('Usuario no encontrado');
            }

            return data;
        } catch (error) {
            console.error("Error al obtener el usuario:", error);
            return null;
        }
    }

    async updateUser(user) {
        try {
            let body;
    
            // Si el producto incluye un archivo, utiliza FormData
            if (user instanceof FormData) {
                body = user;
            } else {
                // Si no es FormData, convierte a JSON
                body = JSON.stringify(user);
            }
    
            const response = await fetch(`${this.baseUrl}&action=update-user`, {
                method: 'POST', // Cambiado a POST para admitir multipart/form-data
                body: body,
                headers: user instanceof FormData ? undefined : {
                    'Content-Type': 'application/json'
                }
            });
    
            if (!response.ok) {
                throw new Error('Error al actualizar el usuario');
            }
    
            return await response.json();
        } catch (error) {
            console.error("Error al actualizar el usuario:", error);
            throw error;
        }
    }
    

    async createUser(formData){
        try {
            const response = await fetch(`${this.baseUrl}&action=create-user`, {
                method: 'POST',
                body: formData // FormData incluye automáticamente los encabezados necesarios
            });
    
            if (!response.ok) {
                throw new Error('Error al crear el usuario');
            }
    
            return await response.json();
        } catch (error) {
            console.error("Error al crear el usuario:", error);
            throw error;
        }
    }

    async deleteUser(user) {
        try {
            const response = await fetch(`${this.baseUrl}&action=delete-user`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_user: user }) // Enviar como objeto con id_producto
            });
    
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el usuario');
            }
    
            return await response.json();
        } catch (error) {
            console.error("Error al eliminar el usuario:", error);
            throw error;
        }
    }
}
