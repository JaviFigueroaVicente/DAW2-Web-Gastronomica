export class ProductosAPI {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async getProductos() {
        try {
            const response = await fetch(`${this.baseUrl}&action=productos`);
            if (!response.ok) {
                throw new Error('No se pudieron obtener los productos');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error(error);
            return [];
        }
    }

    async getProductoIndividual(id) {
        try {
            const response = await fetch(`${this.baseUrl}&action=producto-individual&id=${id}`);
            if (!response.ok) {
                throw new Error('Error al obtener el producto');
            }

            const data = await response.json();
            if (!data) {
                throw new Error('Producto no encontrado');
            }

            return data;
        } catch (error) {
            console.error("Error al obtener el producto:", error);
            return null;
        }
    }

    async updateProducto(producto) {
        try {
            const response = await fetch(`${this.baseUrl}&action=update-producto`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(producto)
            });
    
            if (!response.ok) {
                throw new Error('Error al actualizar el producto');
            }
    
            return await response.json();
        } catch (error) {
            console.error("Error al actualizar el producto:", error);
            throw error;
        }
    }

    async deleteProducto(producto) {
        try {
            const response = await fetch(`${this.baseUrl}&action=delete-producto`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_producto: producto }) // Enviar como objeto con id_producto
            });
    
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el producto');
            }
    
            return await response.json();
        } catch (error) {
            console.error("Error al eliminar el producto:", error);
            throw error;
        }
    }
    
    
}
