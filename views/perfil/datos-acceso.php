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
    <title>Cambiar contraseña</title>
</head>
<body>
    <header>
        <?php
            include 'views/headers/header.php';
        ?>
    </header>

    <main class="datos-personales">
        <!-- Sección para mostrar los datos personales y la opción de cambiar contraseña -->
        <section class="datos-personales-section datos-acceso">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <!-- Breadcrumb (navegación de enlaces) -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?url=cuenta">Mi cuenta</a></li>
                </ol>
            </nav>
            <div>
                <h1>Crear nueva contraseña</h1>
                <p> Estos son tus datos de inicio de sesión:</p>
            </div>

            <div class="datos-email">
                <!-- Muestra el email del usuario (almacenado en la sesión) -->
                <p class="datos-label">E-Mail:</p>
                <p><?= $_SESSION['user_email'] ;?></p>
            </div>

            <div class="datos-email datos-contra">
                <!-- Muestra la contraseña oculta (en forma de asteriscos) y el enlace para cambiarla -->
                <div>
                    <p class="datos-label">Contraseña:</p>
                    <p>********</p>
                </div>
                <a href="?url=datos-acceso/update-password">Cambiar</a>
            </div>
        </section>
    </main>

    <footer>
        <?=
            include 'views/footer/footer.php';
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
