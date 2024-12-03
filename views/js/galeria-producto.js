const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.querySelector('.main-image img');

        // Agregar evento click a cada miniatura
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Remover la clase "active" de todas las miniaturas
                thumbnails.forEach(t => t.classList.remove('active'));

                // Agregar la clase "active" a la miniatura seleccionada
                thumbnail.classList.add('active');

                // Cambiar la imagen principal
                mainImage.src = thumbnail.querySelector('img').src;
            });
        });