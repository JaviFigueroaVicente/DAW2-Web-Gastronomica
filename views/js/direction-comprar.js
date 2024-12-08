// Selecciona todos los botones, radios y collapses
const buttons = document.querySelectorAll('.toggle-btn');
const radios = document.querySelectorAll('.direction-radio');
const collapses = document.querySelectorAll('.collapse');

// Agregar evento de clic a cada botón
buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
        const radio = radios[index];
        const collapse = collapses[index];
        const isExpanded = collapse.classList.contains('show');
        
        // Desmarcar todos los radios y cerrar todos los collapses
        radios.forEach((otherRadio, otherIndex) => {
            if (otherIndex !== index) {
                otherRadio.checked = false;
                collapses[otherIndex].classList.remove('show');
                buttons[otherIndex].setAttribute('aria-expanded', 'false'); // Cambiar aria-expanded a false en el otro
            }
        });

        if (isExpanded) {
            // Si el collapse ya está abierto, cerrarlo y desmarcar el radio
            collapse.classList.remove('show');
            button.setAttribute('aria-expanded', 'false');
            radio.checked = false;
        } else {
            // Si el collapse está cerrado, abrirlo y marcar el radio
            collapse.classList.add('show');
            button.setAttribute('aria-expanded', 'true');
            radio.checked = true;
        }
    });
});