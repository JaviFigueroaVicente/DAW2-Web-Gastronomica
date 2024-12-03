
const sizeRadios = document.querySelectorAll('input[name="size"]');
const selectedSizeText = document.getElementById('selected-size');


sizeRadios.forEach((radio) => {
    radio.addEventListener('change', (event) => {
        selectedSizeText.textContent = `Tamaño: ${event.target.value}`;
    });
});



const minusButton = document.querySelector('.modificar-producto button:first-child'); // Botón "-"
const plusButton = document.querySelector('.modificar-producto button:last-child'); // Botón "+"
const quantityInput = document.querySelector('.modificar-producto input');

// Función para actualizar el estado del botón "-"
function updateMinusButtonState() {
    if (parseInt(quantityInput.value) <= 1) {
        minusButton.disabled = true;
    } else {
        minusButton.disabled = false;
    }
}

// Evento para el botón "+"
plusButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    if (!isNaN(currentValue)) {
        quantityInput.value = currentValue + 1;
    } else {
        quantityInput.value = 1; // Resetear a 1 si no es un número válido
    }
    updateMinusButtonState(); // Actualizar el estado del botón "-"
});

// Evento para el botón "-"
minusButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    if (!isNaN(currentValue) && currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
    updateMinusButtonState(); // Actualizar el estado del botón "-"
});

// Evento para el campo de texto (validación manual)
quantityInput.addEventListener('input', () => {
    let currentValue = parseInt(quantityInput.value);
    if (isNaN(currentValue) || currentValue < 1) {
        quantityInput.value = 1; // Establecer mínimo a 1
    }
    updateMinusButtonState(); // Actualizar el estado del botón "-"
});

// Inicializar el estado del botón "-" al cargar la página
updateMinusButtonState();


const favoritoButton = document.querySelector('.agregar-favoritos');
const favoritoIcon = favoritoButton.querySelector('.favorito-icon');
const favoritoText = favoritoButton.querySelector('.favorito-text');

// Rutas completas de las imágenes
const favoritoGray = 'views/img/icons/favourite_grey.svg';
const favoritoRed = 'views/img/icons/favourite_red.svg';

// Evento para alternar imagen y texto
favoritoButton.addEventListener('click', () => {
    // Verifica la ruta actual de la imagen
    if (favoritoIcon.src.endsWith('favourite_grey.svg')) {
        favoritoIcon.src = favoritoRed; // Cambia a la imagen roja
        favoritoText.textContent = 'Quitar de favoritos'; // Cambia el texto
    } else {
        favoritoIcon.src = favoritoGray; // Cambia a la imagen gris
        favoritoText.textContent = 'Añadir a favoritos'; // Restaura el texto
    }
});