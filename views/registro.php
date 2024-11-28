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
    <title>Registrar</title>
</head>
<body>
    <header>
        <?php
            include "headers/headerInicio.php";
        ?>
    </header>
    <main class="registro">
        <section class="login">
            <h2>Crear una nueva cuenta</h2>
            <div class="div-inicio-sesion">
                <div class="identificacion">
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
                    <form class="form-inicio" method="POST" action="?url=registro/create">
                        <fieldset>
                            <div class="form-group">
                                <input name="email" type="email" id="input1" placeholder=" " required>
                                <label for="email">E-Mail</label>
                            </div>
                            <div class="form-group">
                                <input name="contra" type="password" id="input2" placeholder=" " required>
                                <label for="contra">Contraseña</label>                                                               
                            </div>
                            <small class="small comment">Debe tener un mínimo de 8 carácteres</small>
                            <div class="form-group">
                                <input name="nombre" type="text" id="input1" placeholder=" " required>
                                <label for="nombre">Nombre</label>
                            </div>
                        </fieldset>
                        <fieldset>
                            <p>Ayúdanos a conocerte para mejorar tu experiencia: <small class="comment">(Opcional)</small></p>
                            <div class="form-group">
                                <input name="apellidos" type="text" id="input1" placeholder=" ">
                                <label for="apellidos">Apellidos</label>
                            </div>
                            <small class="small comment">Te lo pedimos para completar tu perfil</small>
                            <div class="form-group">
                                <input name="telefono" type="text" id="input1" placeholder=" ">
                                <label for="telefono">Teléfono</label>
                            </div>
                            <small class="small comment">Te lo pedimos para poder contactar contigo</small>
                            <div class="form-group">
                                <input name="direction" type="text" id="input1" placeholder=" ">
                                <label for="direction">Dirección</label>
                            </div>
                            <small class="small comment">Te lo pedimos para poder enviarte los pedidos</small>
                        </fieldset>
                        <input class="login-submit" type="submit" value="Regístrame">                        
                    </form>
                    <small class="form-aviso">* Al crear esta cuenta aceptas nuestros <a href="">Términos y condiciones</a> y nuestra <a href="">Política de privacidad</a></small>
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