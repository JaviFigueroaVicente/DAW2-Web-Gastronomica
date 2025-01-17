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
    <title>Login</title> 
</head>
<body>
    <header>
        <!-- Incluye el archivo de cabecera de la página -->
        <?php
            include "headers/headerInicio.php";
        ?>
    </header>
    <main>
        <section class="login">
            <h2>Iniciar sesión</h2>
            <div class="div-inicio-sesion">
                <div class="identificacion">
                    <h3>Identifícate para una mejor experiencia</h3>
                    <div class="btn-google">
                        <!-- Botón para iniciar sesión con Google -->
                        <div class="btn-google-div">
                            <a href="">
                                <div>
                                    <img src="views/img/icons/googlelogo.svg" alt="">  <!-- Logo de Google -->
                                    <p>Continuar con Google</p>  <!-- Texto del botón -->
                                </div>                                                      
                            </a>
                        </div>
                    </div>
                    <h5><strong>O inicia sesión con tu email</strong></h5>
                    <!-- Formulario de inicio de sesión -->
                    <form class="form-inicio" method="post" action="?url=login/entrar">
                        <div class="form-group">
                            <input name="login-email" type="text" id="input1" placeholder=" " required>  <!-- Campo de correo electrónico -->
                            <label for="login-email">E-Mail</label>  <!-- Etiqueta de correo electrónico -->
                        </div>
                        <div class="form-group">
                            <input name="login-contra" type="password" id="input2" placeholder=" " required>  <!-- Campo de contraseña -->
                            <label for="login-contra">Contraseña</label>  <!-- Etiqueta de contraseña -->
                        </div>
                        <?php if (!empty($error)) : ?>
                            <!-- Muestra un mensaje de error si existe -->
                            <div class="error-message">
                                <p><?= htmlspecialchars($error) ?></p>
                            </div>
                        <?php endif; ?>
                        <!-- Botón para enviar el formulario -->
                        <input class="login-submit" type="submit" value="Identificarme">
                        <a href="">¿Has olvidado tu contraseña?</a>  <!-- Enlace para recuperar la contraseña -->
                    </form>
                </div>
                <div class="identificacion nueva-cuenta">
                    <h3>¿Eres nuevo cliente?</h3>
                    <p>No te preocupes, crea rápidamente tu nueva cuenta.</p>
                    <div>
                        <!-- Enlace para crear una nueva cuenta -->
                        <a href="?url=registro">
                            <p>Crear mi cuenta</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <!-- Incluye el archivo de pie de página -->
        <?php
            include "footer/footerInicio.php";
        ?>    
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
