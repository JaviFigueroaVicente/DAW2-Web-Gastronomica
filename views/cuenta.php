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
    <title>Mi cuenta</title>
</head>
<body>
    <header>
        <?php
            include 'headers/header.php';
        ?>
    </header>
    <main class="cuenta">
        <section class="cuenta-section">
            <h1>Hola, <?=$_SESSION['user_name']?></h1>
            <div class="container text-center">
                <div class="row row-cols-3">
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/cart.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Mis pedidos</h2>
                                            <p class="card-text">Hacer el seguimiento, devolver un producto, imprimir la factura...</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/profile.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Mis datos personales</h2>
                                            <p class="card-text">Modificar o completar tus datos personales</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">                                
                                    <div class="col-md-3">
                                        <img src="views/img/icons/location_black.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Mis direcciones</h2>
                                            <p class="card-text">Gestionar tus direcciones y preferencias de envío.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/chat_black.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Mis opiniones</h2>
                                            <p class="card-text">Opinar sobre tus compras, gestionar tus comentarios en produtos y blog</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/favourite.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Mis favoritos</h2>
                                            <p class="card-text">Gestionar los productos de tu lista de favoritos</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/security_black.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Acceso y seguridad</h2>
                                            <p class="card-text">Cambiar tu contraseña de acceso.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <a href="">
                                    <div class="col-md-3">
                                        <img src="views/img/icons/question_black.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h2 class="card-title">Ayuda</h2>
                                            <p class="card-text">Contactar con nosotros y acceder a nuestros temas de ayuda.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?=
            include 'footer/footer.php';
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>