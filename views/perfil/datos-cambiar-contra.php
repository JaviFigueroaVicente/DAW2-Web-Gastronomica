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
    <title>Crear nueva contraseña</title>
</head>
<body>
    <header>
        <?php
            include 'views/headers/header.php';
        ?>
    </header>
    <main class="datos-personales">
        <!-- Sección para cambiar la contraseña -->
        <section class="datos-personales-section actu-contra-section">
            <div>
                <h1>Crear nueva contraseña</h1>
                <p>Introduce la nueva contraseña. Te la pediremos siempre que inicies sesión.</p>
            </div>
            <!-- Formulario para ingresar la nueva contraseña -->
            <form action="?url=datos-acceso/update-password/cambiar" class="form-inicio actu-contra" method="POST">
                <div class="form-group">
                    <!-- Campo para la nueva contraseña -->
                    <input name="actu-contra" type="password" placeholder=" " required>
                    <label for="actu-contra">Contraseña</label>
                </div>
                
                <!-- Mensaje de requisito para la contraseña -->
                <small class="small comment">Debe tener un mínimo de 8 carácteres</small>
                
                <div class="form-group">
                    <!-- Campo para confirmar la nueva contraseña -->
                    <input name="confirm-contra" type="password" placeholder=" " required>
                    <label for="confirm-contra">Confirma Contraseña</label>
                </div>

                <!-- Botón para enviar el formulario -->
                <input class="login-submit" type="submit" value="Guardar contraseña">
            </form>
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