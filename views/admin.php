
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/styles.css">   
    <link rel="icon" href="views/img/icons/icono.svg" type="image/x-icon">
    <title>Mammoth's Kitchen</title>  
    
</head>
<body>
    <header>
        <?php
            include_once "views/headers/header.php";
        ?>
    </header>
   <main class="admin-main">
        <!-- Sección que contiene los datos de la sesión -->
        <p id="session-data" data-id-user="<?php echo $_SESSION['user_id']; ?>"></p>
        <!-- Se incluye el id de usuario desde la sesión. Se almacena como un atributo de datos en el <p> para poder utilizarlo en JS -->

        <!-- Sección para la administración de la web -->
        <section class="cesta">
            <h2>Administrar Web</h2>
        </section>

        <!-- Sección que contiene el contenido principal, dividida en una barra lateral (menú) y una área de contenido -->
        <section class="row">
            <!-- Menú lateral con opciones de administración -->
            <aside class="menu-lateral admin-lateral col-lg-2">
                <div class="btn-group-vertical" role="group" aria-label="Vertical radio toggle button group">
                    <!-- Botones de opción (radio) para seleccionar diferentes secciones de administración -->
                    <input type="radio" class="btn-check" data-section="productos" name="vbtn-radio" id="vbtn-radio1" autocomplete="off" checked>
                    <label class="btn btn-outline-danger" for="vbtn-radio1">Productos</label>

                    <input type="radio" class="btn-check" data-section="pedidos" name="vbtn-radio" id="vbtn-radio2" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio2">Pedidos</label>

                    <input type="radio" class="btn-check" data-section="usuarios" name="vbtn-radio" id="vbtn-radio3" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio3">Usuarios</label>

                    <input type="radio" class="btn-check" data-section="logs" name="vbtn-radio" id="vbtn-radio4" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio4">Logs</label>
                </div>
            </aside>
            <!-- Área principal de contenido, donde se mostrará la tabla o información correspondiente -->
            <div id="tabla-mostrar" class="col-lg-7">
                <!-- Este espacio se usará para mostrar la tabla o datos correspondientes a la sección seleccionada -->
            </div>
            <!-- Modal para mostrar detalles u opciones adicionales -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- El contenido del modal se puede agregar dinámicamente aquí -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?php
            include_once "views/footer/footer.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="api/main.js"></script>

</body>
</html>