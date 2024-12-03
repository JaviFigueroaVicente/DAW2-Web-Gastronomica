// Gestion de tamaños
const sizeRadios = document.querySelectorAll('input[name="size"]');
const selectedSizeText = document.getElementById('selected-size');


sizeRadios.forEach((radio) => {
    radio.addEventListener('change', (event) => {
        selectedSizeText.textContent = `Tamaño: ${event.target.value}`;
    });
});


// Función para actualizar los precios de todos los bloques, incluyendo "producto-borrar"
function actualizarPrecios() {
    // Obtener todos los divs de precios (incluyendo producto-borrar)
    const bloquesPrecios = document.querySelectorAll('.header-precios');
    
    // Obtener las cantidades (tomamos el valor de cualquier input de cantidad, ya que todos están sincronizados)
    const cantidades = document.querySelectorAll('.cantidad-productos');
    const cantidad = parseInt(cantidades[0].value) || 0;

    // Recorrer todos los bloques de precios
    bloquesPrecios.forEach((bloque) => {
        // Obtener los elementos de precio rebajado y precio antiguo en cada bloque
        const rebajado = bloque.querySelector('.rebajado');
        const precioRebajado = parseFloat(rebajado.getAttribute('data-precio'));
        
        const precioAntiguo = bloque.querySelector('.precio-antiguo');
        const precioAntiguoBase = parseFloat(precioAntiguo.getAttribute('data-precio'));

        // Verificar si los valores son números válidos
        if (isNaN(precioRebajado) || isNaN(precioAntiguoBase)) {
            console.error("Uno de los precios no es un número válido");
            return; // Detenemos la ejecución si hay un valor no válido
        }
        
        // Calcular el subtotal para los precios rebajado y antiguo
        const subtotalRebajado = cantidad * precioRebajado;
        const subtotalAntiguo = cantidad * precioAntiguoBase;

        // Actualizar los precios en el bloque correspondiente
        rebajado.textContent = `${formatearPrecio(subtotalRebajado)}€`;
        precioAntiguo.textContent = `${formatearPrecio(subtotalAntiguo)}€`;
    });

    // Actualizar la cantidad de artículos en el sumario
    document.querySelector('.num-articulos').textContent = `(${cantidad} artículo${cantidad !== 1 ? 's' : ''})`;

    // Actualizar el subtotal en el sumario con el precio rebajado (el de la primera instancia)
    const primerPrecioRebajado = bloquesPrecios[0].querySelector('.rebajado');
    const precioRebajadoSubtotal = parseFloat(primerPrecioRebajado.textContent.replace('€', '').trim());
    document.querySelector('.subtotal').textContent = `${formatearPrecio(precioRebajadoSubtotal)}€`;

    // Habilitar/deshabilitar los botones
    deshabilitarBotones();
}

// Función para habilitar o deshabilitar el botón "-"
function deshabilitarBotones() {
    const botonesReducir = document.querySelectorAll('.btn-reducir');
    const cantidades = document.querySelectorAll('.cantidad-productos');
    const botonesAumentar = document.querySelectorAll('.btn-aumentar');
    

    cantidades.forEach((cantidadInput, index) => {
        const cantidad = parseInt(cantidadInput.value) || 0;
        const botonReducir = botonesReducir[index];

        // Deshabilitar si la cantidad es 1
        if (cantidad <= 1) {
            botonReducir.setAttribute('disabled', 'true');
        } else {
            botonReducir.removeAttribute('disabled');
        }       
    });   

    cantidades.forEach((cantidadInput, index) => {
        const stock = parseInt(document.querySelector('.stock-producto').value);
        const cantidad = parseInt(cantidadInput.value) || 0;
        const botonAumentar = botonesAumentar[index];

        // Deshabilitar si la cantidad es 1
        if (cantidad >= stock) {
            botonAumentar.setAttribute('disabled', 'true');
        } else {
            botonAumentar.removeAttribute('disabled');
        }       
    });   
    
}



// Función para sincronizar la cantidad entre ambos inputs
function sincronizarCantidades(cantidadInput) {
    const cantidad = parseInt(cantidadInput.value) || 0;
    const cantidades = document.querySelectorAll('.cantidad-productos');
    
    // Sincronizar las cantidades
    cantidades.forEach(input => {
        input.value = cantidad;
    });

    // Actualizar los precios después de sincronizar
    actualizarPrecios();
}

// Función para formatear el precio con coma como separador decimal
function formatearPrecio(precio) {
    return precio.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Evento para aumentar la cantidad
document.querySelectorAll('.btn-aumentar').forEach(boton => {
    boton.addEventListener('click', (e) => {
        const inputCantidad = e.target.previousElementSibling;
        let cantidad = parseInt(inputCantidad.value) || 0;
        cantidad += 1;
        inputCantidad.value = cantidad;
        
        // Sincronizar cantidades
        sincronizarCantidades(inputCantidad);
    });
});

// Evento para reducir la cantidad
document.querySelectorAll('.btn-reducir').forEach(boton => {
    boton.addEventListener('click', (e) => {
        const inputCantidad = e.target.nextElementSibling;
        let cantidad = parseInt(inputCantidad.value) || 0;
        
        if (cantidad > 1) {
            cantidad -= 1;
            inputCantidad.value = cantidad;
            
            // Sincronizar cantidades
            sincronizarCantidades(inputCantidad);
        }
    });
});

// Inicialización
actualizarPrecios();




// Gestion de favoritos

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
        favoritoText.textContent = 'Añadir a mis favoritos'; // Restaura el texto
    }
});