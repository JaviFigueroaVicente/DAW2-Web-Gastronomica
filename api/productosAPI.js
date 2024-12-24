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
            const response = await fetch(`${this.baseUrl}&action=producto_individual&id=${id}`);
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
}
