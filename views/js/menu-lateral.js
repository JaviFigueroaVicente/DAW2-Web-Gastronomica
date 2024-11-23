document.addEventListener('DOMContentLoaded', () => {
    const menuHeaders = document.querySelectorAll('.menu-header');

    menuHeaders.forEach((header) => {
        const target = document.querySelector(header.getAttribute('data-bs-target'));

        // Detecta cuando el colapso está completamente mostrado
        target.addEventListener('shown.bs.collapse', () => {
            header.textContent = `− ${header.textContent.trim().slice(2)}`; // Cambia a "−"
        });

        // Detecta cuando el colapso está completamente oculto
        target.addEventListener('hidden.bs.collapse', () => {
            header.textContent = `+ ${header.textContent.trim().slice(2)}`; // Cambia a "+"
        });
    });
});
