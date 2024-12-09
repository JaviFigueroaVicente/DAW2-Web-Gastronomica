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
            <form action="">
                <div class="tramitar col-8">
                    <h1>Tramita tu pedido</h1>                
                    <div class="tramitar-direction">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirectionRecogida" aria-expanded="false" aria-controls="collapseDirectionRecogida">
                            <div class="direction-header">
                                <span class="paso-tramitar">1</span>
                                <h2>¿Dónde deseas recibir tu pedido?</h2>
                            </div>
                        </button>           
                        <div class="direction-body collapse show" id="collapseDirectionRecogida">
                            <div class="form-inicio" action="">
                                <div class="direction-selection">
                                    <img src="views/img/icons/location_black.svg" alt="">
                                    <span>Selecciona tu país de envío<button type="button">España</button></span>
                                </div>
                                <div class="direction-recogida" id="collapseDomicilio">
                                    <div class="direction-tienda">                                
                                        <input id="direction-radio" type="radio" name="deliveryOption" value="1" class="direction-radio">
                                        <label for="direction-radio">Recoger en tienda</label>
                                        <p>Gratis</p>                             
                                    </div>
                                    <div class="direction-domicilio">
                                        <div class="domicilio-button">
                                            <button class= "btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDomicilioDetails" aria-expanded="false" aria-controls="collapseDomicilioDetails">
                                                <input id="radio-domicilio" type="radio" name="deliveryOption" value="2" class="direction-radio">
                                            </button> 
                                            <label for="radio-domiciilo"><strong>Enviar a domicilio</strong></label>
                                            <p><strong> 4,99 €</strong> con envío estándar</p> 
                                        </div>                                                          
                                        <div class="collapse" id="collapseDomicilioDetails">
                                            <div class="card card-body">                                            
                                                <div class="form-group">
                                                    <input name="login-email" type="text" id="input1" value="<?= $_SESSION['user_direction'] ;?>" placeholder=" " required>
                                                    <label for="login-email">Dirección</label>
                                                </div>
                                                <div class="actualizar-direction">
                                                    <div class="custom-checkbox-container">
                                                        <input type="checkbox" id="custom-checkbox" class="custom-checkbox">
                                                        <label for="custom-checkbox"></label>                                                    
                                                    </div>
                                                    <p>Actualizar mi dirección</p>
                                                </div>                                                  
                                            </div>
                                        </div>                                      
                                    </div>                                   
                                </div>
                                <div class="direction-factura">
                                    <div class="factura">
                                        <div class="custom-checkbox-container">
                                            <input type="checkbox" id="checkbox-factura" class="custom-checkbox">
                                            <label for="checkbox-factura"></label>                                                    
                                        </div>
                                        <p>Necesito factura</p>
                                        <img src="views/img/icons/pregunta.webp" alt="">
                                    </div> 
                                </div>
                            </div> 
                        </div>                   
                    </div>
                    <div class="metodo-pago">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMetodoPago" aria-expanded="false" aria-controls="collapseMetodoPago">
                            <div class="direction-header">
                                <span class="paso-tramitar">2</span>
                                <h2>¿Cómo quieres pagar?</h2>
                            </div>
                        </button>    
                        <div class="collapse" id="collapseMetodoPago">
                            <p class="seleccion-metodo">Selecciona un método de pago o si lo prefieres financia tu pedido.</p>
                            <article>
                                <div class="opcion-pago">
                                    <div>
                                        <input id="radio-domicilio" type="radio" name="PayOption" value="Card" class="direction-radio">
                                        <p><strong>Tarjeta</strong></p>
                                    </div>
                                    <img src="views/img/icons/tarjeta-visa-master-card.webp" alt="">
                                </div>
                                <div class="opcion-pago">
                                    <div>
                                        <input id="radio-domicilio" type="radio" name="PayOption" value="GPay" class="direction-radio">
                                        <p><strong>Apple Pay o G Pay</strong></p>
                                    </div>
                                    <div>
                                        <img src="views/img/icons/apple-pay.webp" alt="">
                                        <img class="g-pay" src="views/img/icons/google-pay.webp" alt="">
                                    </div>
                                </div>
                                <div class="opcion-pago">
                                    <div>
                                        <input id="radio-domicilio" type="radio" name="PayOption" value="Bizum" class="direction-radio">
                                        <p><strong>Bizum</strong></p>
                                    </div>
                                    <img class="bizum" src="views/img/icons/bizum.webp" alt="">
                                </div>
                                <div class="opcion-pago ultima">
                                    <div>
                                        <input id="radio-domicilio" type="radio" name="PayOption" value="Transfer" class="direction-radio">
                                        <p><strong>Transferencia</strong></p>
                                    </div>                                    
                                </div>
                            </article>
                        </div>                      
                    </div>
                    <div class="resumen-pedido">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResumenPedido" aria-expanded="false" aria-controls="collapseResumenPedido">
                            <div class="direction-header">
                                <span class="paso-tramitar">3</span>
                                <h2>Revisa tu pedido</h2>
                            </div>
                        </button>    
                        <div class="collapse" id="collapseResumenPedido">
                            <div class="card card-body">                                            
                                <div class="form-group">
                                    <input name="login-email" type="text" id="input1" value="<?= $_SESSION['user_direction']; ?>" placeholder=" " required>
                                    <label for="login-email">Dirección</label>
                                </div>
                                <div class="actualizar-direction">
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" id="custom-checkbox" class="custom-checkbox">
                                        <label for="custom-checkbox"></label>                                                    
                                    </div>
                                    <p>Actualizar mi dirección</p>
                                </div>                                                  
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class= col-4>

                </div>
            </form>
        </section>        
    </main>
    <footer>
        <?php
            include_once "views/footer/footerInicio.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>