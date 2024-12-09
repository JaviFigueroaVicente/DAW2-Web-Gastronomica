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
    <title>Mis datos personales</title>
</head>
<body>
    <header>
        <?php
            include 'views/headers/header.php';
        ?>
    </header>
    <main class="datos-personales" >
        <section class="datos-personales-section">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?url=cuenta">Mi cuenta</a></li>
                </ol>
            </nav>
            <div>
                <h1>Mis datos personales</h1>
                <p class="politicas">En Mammoth's Kitchen nos tomamos muy en serio tu privacidad y protegemos tus datos personales. Conoce más sobre nuestra <a href="">Política de Privacidad.</a></p>
            </div>
            <div class="datos-email">
                <p class="datos-label">E-Mail:</p>
                <p><?php echo $_SESSION['user_email'] ?></p>
            </div>
            <form class="form-inicio" action="?url=datos-personales/update-perfil" method="post">
                <div class="form-group">
                    <input name="nombre-actualizar" type="text" placeholder=" " value="<?php echo $_SESSION['user_name'] ?>" required >
                    <label for="nombre-actualizar">Nombre</label>
                </div>
                <div class="form-group">
                    <input name="apellidos-actualizar" type="text" placeholder=" " value="<?php echo $_SESSION['user_apellidos'] ;?>">
                    <label for="apellidos-actualizar">Apellidos</label>                                                               
                </div>                
                <div class="form-group">
                    <input name="direction-actualizar" type="text" placeholder=" " value="<?php echo $_SESSION['user_direction'] ;?>">
                    <label for="direction-actualizar">Dirección</label>
                </div>
                <div class="form-group">
                    <input name="telefono-actualizar" type="text" placeholder=" " value="<?php echo $_SESSION['user_telefono'] ;?>">
                    <label for="telefono-actualizar">Telefono</label>
                </div>
                <small class="small comment">Sólo te llamaremos si hay una incidencia con tus pedidos. Si contactas con nosotros lo usaremos para buscar tus pedidos.</small>
                <input class="login-submit" type="submit" value="Actualizar"> 
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
