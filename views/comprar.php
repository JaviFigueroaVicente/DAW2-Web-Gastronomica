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
        <form action="?url=comprar/tramitar-pedido" method="POST">
            <section class="comprar row">
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
                                        <input require id="direction-radio" type="radio" name="deliveryOption" value="tienda" class="direction-radio" checked>
                                        <label for="direction-radio">Recoger en tienda</label>
                                        <p>Gratis</p>                             
                                    </div>
                                    <div class="direction-domicilio">
                                        <div class="domicilio-button">
                                            <button class= "btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDomicilioDetails" aria-expanded="false" aria-controls="collapseDomicilioDetails">
                                                <input require id="radio-domicilio" type="radio" name="deliveryOption" value="<?= $_SESSION['user_direction']?>" class="direction-radio">
                                            </button> 
                                            <label for="radio-domicilio"><strong>Enviar a domicilio</strong></label>
                                            <p><strong> 4,99 €</strong> con envío estándar</p> 
                                        </div>                                                          
                                        <div class="collapse" id="collapseDomicilioDetails">
                                            <div class="card card-body">                                            
                                                <div class="form-group">
                                                    <input name="login-email" type="text" id="domicilio" value="<?= $_SESSION['user_direction'] ;?>" placeholder=" " required>
                                                    <label for="login-email">Dirección</label>
                                                </div>
                                                <div class="actualizar-direction">
                                                    <div class="custom-checkbox-container">
                                                        <input type="checkbox" id="custom-checkbox" class="custom-checkbox" value="Tienda" name="deliveryOption">
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
                                        <input id="radio-domicilio" type="radio" name="PayOption" value="Card" class="direction-radio" checked>
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
                                <div class="actualizar-direction">
                                    <?php    
                                    foreach ($cesta as $producto):  
                                    ?>
                                    <div class="card card-finalizar">
                                        <a href="?url=productos/producto-individual&id=<?=$producto['id_producto']?>"><img src="data:image/webp;base64,<?= base64_encode($producto['foto_producto']) ?>" class="card-img-top"  class="card-img-top" alt="..."></a>
                                        <div class="card-body">
                                            <h5><a href="?url=productos/producto-individual&id=<?=$producto['id_producto']?>"><?=$producto['nombre_producto']?></a></h5>
                                            <p class="card-text texto-tamaño comment">Tamaño: <?= $producto['tamaño']?></p>
                                            <div class="producto-borrar">                                                      
                                                <p class="card-text texto-cantidad comment">Cantidad: <?= $producto['cantidad']?></p> 
                                                <p><?=number_format($producto['precio_producto']*$producto['cantidad'], 2, ',', '.')?>€</p>
                                            </div>                                            
                                        </div>                                        
                                    </div> 
                                    <?php
                                    endforeach; 
                                    ?>        
                                </div>     
                                <div class="revisar-bottom">
                                    <p>Elige una opción de envío para estos productos</p>
                                    <div>
                                        <input id="radio-domicilio" type="radio" name="envioEstandar" value="envioEstandar" class="direction-radio" checked>
                                        <p>Envío Estandar - GRATIS</p>
                                        <p class="green">Entrega estimada <strong>16/12/2024</strong></p>
                                    </div>
                                </div>                                             
                            </div>                            
                        </div>                      
                    </div>
                </div>
                <div class= col-4>
                    <aside class="sticky-top">
                        <h2>Resumen de tu pedido</h2>
                        <div class="tramitar-menu">
                            <div class="tramitar-subtotal">
                                <div>
                                    <p>Subtotal</p>
                                    <p class="precio-subtotal"><?php
                                    $subtotal = 0;
                                    foreach ($cesta as $producto) {
                                        $subtotal += $producto['precio_producto']*$producto['cantidad'];
                                    }
                                    echo number_format($subtotal, 2, ',', '.');
                                    ?> €</p>
                                </div>
                                <div>
                                    <div class="div-gastos-envio">
                                        <p>Gastos de envío GRATIS</p>
                                    </div>                            
                                    <p class="gastos-envio">0,00 €</p>
                                </div>
                            </div>
                            <div class="tramitar-total">
                                <div class="total">
                                    <p>Total</p>
                                    <p class="precio-total"><?php
                                    $total = 0;
                                    foreach ($cesta as $producto) {
                                        $total += $producto['precio_producto']*$producto['cantidad'];
                                    }
                                    echo number_format($total, 2, ',', '.');
                                    ?> €</p>
                                    <input name="precio_total_pedido" type="text" value="<?= $total ?>" hidden>
                                </div>
                                <div class="ahorrado">
                                    <p class="ahorrado-verde">Has ahorrado 5,75€</p>
                                    <p>* IVA incluido</p>
                                </div>
                            </div>                                                                          
                        </div>
                        <div class="tramitar-menu ">
                            <div class="tramitar-total tramitar-checkbox">
                                <div class="total direction-body terminos">
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" id="checkbox-terminos" class="custom-checkbox" required checked>
                                        <label for="checkbox-terminos"></label>           
                                    </div>
                                    <p><strong>He leído y acepto </strong> las <a href="">Condiciones de compra</a> de www.mammothskitchen.com</p>
                                </div>                                
                            </div>  
                        </div>
                        <button class="agregar-cesta" type="submit">Tramitar pedido</button>
                    </aside>
                </div>
            </section>   
        </form>     
    </main>
    <footer>
        <?php
            include_once "views/footer/footerInicio.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>