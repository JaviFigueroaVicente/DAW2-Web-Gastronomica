export class PedidosAPI {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async getPedidos() {
        try {
            const response = await fetch(`${this.baseUrl}&action=pedidos`);
            if (!response.ok) {
                throw new Error('No se pudieron obtener los pedidos');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error(error);
            return [];
        }
    }
    async getPedidoIndividual(id) {
        try {
            const response = await fetch(`${this.baseUrl}&action=pedido-individual&id=${id}`);
            if (!response.ok) {
                throw new Error('Error al obtener el pedido');
            }

            const data = await response.json();
            if (!data) {
                throw new Error('Pedido no encontrado');
            }

            return data;
        } catch (error) {
            console.error("Error al obtener el pedido:", error);
            return null;
        }
    }
    
    async updatePedido(pedido) {
        try {
            let body;

            if(pedido instanceof FormData) {
                body = pedido;
            } else {
                body = JSON.stringify(pedido);
            }
        
            const response = await fetch(`${this.baseUrl}&action=update-pedido`, {
                method: 'POST',
                body: body,
                headers: pedido instanceof FormData ? undefined : {
                    'Content-Type': 'application/json'
                },
            });

            if (!response.ok) {
                throw new Error('Error al actualizar el pedido');
            }

            return await response.json();
        } catch (error) {
            console.error("Error al actualizar el pedido:", error);
            throw error;
        }
    }
    
    async deletePedido(id) {
        try {
            const response = await fetch(`${this.baseUrl}&action=delete-pedido`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_pedido: id })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error al eliminar el pedido');
            }

            return await response.json();
        } catch (error) {
            console.error("Error al eliminar el pedido:", error);
            throw error;
        }
    }

    async createPedido(pedido) {
        try {
            const response = await fetch(`${this.baseUrl}&action=create-pedido`, {
                method: 'POST',
                body: pedido
            });

            if (!response.ok) {
                throw new Error('Error al crear el pedido');
            }

            return await response.json();
        } catch (error) {
            console.error("Error al crear el pedido:", error);
            throw error;
        }
    }

}