import { ProductosAPI } from './productosAPI.js';
import { PedidosAPI } from './pedidosAPI.js';
import { UserAPI } from './userAPI.js';
import { OfertasAPI } from './ofertasAPI.js';

document.addEventListener('DOMContentLoaded', () => {
    const contentContainer = document.getElementById('content-container');
    const buttons = document.querySelectorAll('.btn-check');

    const productosAPI = new ProductosAPI(contentContainer);
    const pedidosAPI = new PedidosAPI(contentContainer);
    const usuariosAPI = new UserAPI(contentContainer);
    const ofertasAPI = new OfertasAPI(contentContainer);

    const handleSectionChange = async (section) => {
        contentContainer.innerHTML = "<p>Cargando...</p>"; 
        try {
            if (section === 'productos') await productosAPI.load();
            else if (section === 'pedidos') await pedidosAPI.load();
            else if (section === 'usuarios') await usuariosAPI.load();
            else if (section === 'ofertas') await ofertasAPI.load();
        } catch (error) {
            contentContainer.innerHTML = `<p>Error al cargar ${section}: ${error.message}</p>`;
        }
    };

    buttons.forEach((button) => {
        button.addEventListener('change', (e) => {
            if (e.target.checked) {
                const section = e.target.dataset.section;
                handleSectionChange(section);
            }
        });
    });

    handleSectionChange('productos');
});

document.getElementById('saveChanges').addEventListener('click', () => {
    this.saveEditModal();
});