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
    <title>Mammoth's Kitchen</title>  
</head>
<body>
    <header>
        <?php
            include_once "views/headers/headerInicio.php";
        ?>
    </header>
    <main>
        <section class="comprar">
            <div class="tramitar col-8">
                <h1>Tramita tu pedido</h1>
                <div class="tramitar-direction">
                    <div class="direction-header">
                        <span class="paso-tramitar">1</span>
                        <h2>¿Dónde deseas recibir tu pedido?</h2>
                    </div>
                    <div class="direction-body">
                        <div class="direction-selection">
                            <img src="views/img/icons/location_black.svg" alt="">
                            <span>Selecciona tu país de envío<button type="button">España</button></span>
                        </div>
                        <div class="direction-recogida">
                            <div class="direction-tienda">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTienda" aria-expanded="false" aria-controls="collapseTienda">
                                    <input id="direction-radio" type="radio" name="deliveryOption" value="1" class="direction-radio">
                                    <label for="direction-radio">Recoger en tienda</label>
                                    Gratis
                                </button>                            
                                <div class="collapse" id="collapseTienda">
                                    <div class="card card-body">
                                        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                    </div>
                                </div>
                            </div>
                            <div class="direction-domicilio">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDomicilio" aria-expanded="false" aria-controls="collapseDomicilio">
                                    <input id="radio-domicilio" type="radio" name="deliveryOption" value="2" class="direction-radio">
                                    <label for="radio-domiciilo"><strong>Enviar a domicilio</strong></label>
                                    <strong> 4,99 €</strong> con envío estándar
                                </button>                            
                                <div class="collapse" id="collapseDomicilio">
                                    <div class="card card-body">
                                        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="direction-factura">

                        </div>
                    </div>
                </div>
            </div>
            <div class= col-4>

            </div>
        </section>
        
    </main>
    <footer>
        <?php
            include_once "views/footer/footerInicio.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/direction-comprar.js"></script>
</body>
</html>