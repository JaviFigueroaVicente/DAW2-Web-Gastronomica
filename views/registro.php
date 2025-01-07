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
    <title>Registrar</title>
</head>
<body>
    <header>
        <?php
            include "headers/headerInicio.php";
        ?>
    </header>
    <main class="registro">
        <!-- Sección para la creación de una nueva cuenta -->
        <section class="login">
            <h2>Crear una nueva cuenta</h2>
            <div class="div-inicio-sesion">
                <div class="identificacion">
                    <!-- Opción para registrarse mediante Google -->
                    <div class="btn-google">
                        <div class="btn-google-div">
                            <a href="">
                                <div>
                                    <img src="views/img/icons/googlelogo.png" alt="">
                                    <p>Continuar con Google</p>
                                </div>                                                      
                            </a>
                        </div>
                    </div>
                    <h5><strong>O regístrate con tus datos personales</strong></h5>
                    <!-- Formulario de registro con datos personales -->
                    <?php
                        // Display any errors from the session
                        if (isset($_SESSION['errors'])) {
                            foreach ($_SESSION['errors'] as $error) {
                                echo "<p style='color: red;'>$error</p>";
                            }
                            unset($_SESSION['errors']); // Clear the errors after displaying them
                        }
                    ?>
                    <form class="form-inicio" method="POST" action="?url=registro/create">
                        <fieldset>
                            <!-- Campo de correo electrónico -->
                            <div class="form-group">
                                <input name="email" type="email" id="input1" placeholder=" "  value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">
                                <label for="email">E-Mail</label>
                            </div>

                            <!-- Campo de contraseña -->
                            <div class="form-group">
                                <input name="contra" type="password" id="input2" placeholder=" ">
                                <label for="contra">Contraseña</label>                                                               
                            </div>
                            <small class="small comment">Debe tener un mínimo de 8 carácteres</small>

                            <!-- Campo de nombre -->
                            <div class="form-group">
                                <input name="nombre" type="text" id="input1" placeholder=" " value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">
                                <label for="nombre">Nombre</label>
                            </div>
                        </fieldset>
                        <fieldset>
                            <!-- Sección opcional para más información -->
                            <p>Ayúdanos a conocerte para mejorar tu experiencia: <small class="comment">(Opcional)</small></p>

                            <!-- Campo de apellidos -->
                            <div class="form-group">
                                <input name="apellidos" type="text" id="input1" placeholder=" " value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : '' ?>">
                                <label for="apellidos">Apellidos</label>
                            </div>
                            
                            <!-- Campo de teléfono -->
                            <div class="form-group">
                                <input name="telefono" type="text" id="input1" placeholder=" " value="<?= isset($_SESSION['form_data']['telefono']) ? $_SESSION['form_data']['telefono'] : '' ?>">
                                <label for="telefono">Teléfono</label>
                            </div>
                            
                            <!-- Campo de dirección -->
                            <div class="form-group">
                                <input name="direction" type="text" id="input1" placeholder=" " value="<?= isset($_SESSION['form_data']['direction']) ? $_SESSION['form_data']['direction'] : '' ?>">
                                <label for="direction">Dirección</label>
                            </div>
                        </fieldset>

                        <!-- Botón de envío del formulario -->
                        <input class="login-submit" type="submit" value="Regístrame">
                    </form>

                    <?php
                    // Clear the form data after it is displayed in the form
                    unset($_SESSION['form_data']);
                    ?>

                    <!-- Aviso de términos y condiciones -->
                    <small class="form-aviso">* Al crear esta cuenta aceptas nuestros <a href="">Términos y condiciones</a> y nuestra <a href="">Política de privacidad</a></small>
                    <!-- Enlace para iniciar sesión si ya tienes una cuenta -->
                    <div class="cuenta-login-link">
                        <p>¿Ya tienes una cuenta?</p>
                        <a href="?url=login">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?php
            include "footer/footerInicio.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>