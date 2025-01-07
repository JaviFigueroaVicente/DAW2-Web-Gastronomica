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
    <title>Finalizar</title>
</head>
<body>
    <header>
        <?php
            include_once "headers/header.php";
        ?>    
    </header>
    <main>
        <!-- Sección principal de la cesta -->
        <section class= "cesta">
            <h2>Mi cesta</h2>
            <!-- Muestra la cantidad de artículos en la cesta -->
            <p>(<?php if($totalCesta>0){
                    echo $totalCesta;
                }else{
                    echo 0;
                } ?> artículos)</p>
        </section>        
        <!-- Sección de productos para finalizar compra -->
        <section class="productos-finalizar">
            <?php if($totalCesta !=0 ){ ?>
                <div class="finalizar-izquierda">
                    <div class="productos-cesta">
                        <?php    
                        // Recorre los productos en la cesta
                        foreach ($cesta as $producto):  
                        ?>
                        <div class="card card-finalizar">
                            <!-- Imagen y enlace al producto individual -->
                            <a href="?url=productos/producto-individual&id= <?=$producto['id_producto']?>"><img src="data:image/webp;base64,<?= base64_encode($producto['foto_producto']) ?>" class="card-img-top"  class="card-img-top" alt="..."></a>
                            <div class="card-body">
                                <?=$producto['nombre_producto']?>
                                <p class="card-text texto-tamaño">Tamaño: <?= $producto['tamaño']?></p>
                                <p class="card-text texto-entrega">Entrega estimada, 21:30h 25 oct. 2024</p>                                                      
                                <!-- Formulario para modificar cantidad de producto -->
                                <form action="?url=finalizar/modificar-producto-cesta" method="POST">
                                    <div class="modificar-producto">  
                                        <input type="text" name="tamaño" value="<?= $producto['tamaño']?>" hidden>                                  
                                        <input class="stock-producto" type="text" hidden value="<?=number_format($producto['stock_producto'], 2, ',', '.')?>">                                 
                                        <input type="text" name="producto_id" value="<?=$producto['id_producto']?>" hidden>
                                        <button type="submit" name="modificar" value="reducir" class="btn-reducir" <?php if($producto['cantidad']<= 1 ){echo 'disabled';}?>>-</button>
                                        <input name="cantidad" type="text" class="cantidad-producto" value="<?=$producto['cantidad']?>">
                                        <button type="submit" name="modificar" value="aumentar" class="btn-aumentar" <?php if($producto['cantidad'] == $producto['stock_producto']){echo 'disabled';}?>>+</button>
                                    </div>
                                </form>       
                                <!-- Muestra descuento si existe -->
                                <?php if (!empty($producto['descuento_oferta'])){ ?>
                                    <p class="card-text texto-descuento">
                                        <img src="views/img/icons/check-verde.svg" alt="">
                                        <?= htmlspecialchars($producto['descuento_oferta']) ?>% de descuento
                                    </p>
                                <?php } ?>                                                     
                            </div>
                            <!-- Opción para eliminar el producto -->
                            <div class="producto-borrar">
                                <form action="?url=finalizar/eliminar-producto-cesta" method="POST">
                                    <input type="text" name="producto_id" value="<?=$producto['id_producto']?>" hidden>
                                    <button type="submit" class="btn-close" aria-label="Close"></button>
                                </form>              
                                <div>
                                    <!-- Precio con descuento si aplica -->
                                    <p <?php if (!empty($producto['descuento_oferta'])){ ?> class="precio-descuento"> <?=number_format($producto['precio_producto']*$producto['cantidad']*(1-$producto['descuento_oferta']/100), 2, ',', '.')?>€ <?php } ?> </p>
                                    <!-- Precio original -->
                                    <p <?php if (!empty($producto['descuento_oferta'])){ ?> class="precio-tachado" <?php } ?> > <?=number_format($producto['precio_producto']*$producto['cantidad'], 2, ',', '.')?>€</p>
                                </div>                                              
                            </div>
                        </div> 
                        <?php endforeach; ?>
                    </div>
                    <!-- Información adicional sobre el cupón y los impuestos -->
                    <div class="cesta-bottom ">
                        <div class="d-flex align-items-center">
                            <img src="views/img/icons/etiqueta.svg" alt="">
                            <div>
                                <p class="cupon">¿Tienes un cupón?</p>
                                <form action="?url=finalizar" method="post">
                                    <label for="cupon_nombre"></label>
                                    <input name="cupon_nombre" type="text" placeholder="Código">
                                    <button type="submit">Aplicar</button>
                                </form>
                            </div>                        
                        </div>
                        <p class="iva">* En las ventas fuera de la UE no se repercutirá IVA (21%), no obstante el sistema aduanero aplicará las cargas impositivas correspondientes.</p>
                    </div>
                </div>   
                <!-- Resumen del pedido con el total a pagar -->
                <div class="tramitar-pedido ">
                    <aside class="sticky-top">
                        <div class="tramitar-menu">
                            <!-- Subtotal del pedido -->
                            <div class="tramitar-subtotal">
                                <div>
                                    <p>Subtotal</p>
                                    <p class="precio-subtotal"><?php
                                    $subtotal = 0;
                                    // Calcula el subtotal de todos los productos
                                    foreach ($cesta as $producto) {
                                        $subtotal += $producto['precio_producto']*$producto['cantidad'];
                                    }
                                    if (!empty($producto['descuento_oferta'])){
                                        $subtotal = $subtotal*(1-$producto['descuento_oferta']/100);
                                    }
                                    echo number_format($subtotal, 2, ',', '.');
                                    ?> €</p>
                                </div>
                                <div>
                                    <div class="div-gastos-envio">
                                        <p>Gastos de envío GRATIS</p>
                                        <a href=""><img class="subtotal-icon" src="views/img/icons/pregunta.webp" alt=""></a>
                                    </div>                            
                                    <p class="gastos-envio">0,00 €</p>
                                </div>
                            </div>
                            <div class="tramitar-total">                                  
                                <div class="total">
                                    <p>Total</p>
                                    <p class="precio-total"><?php
                                    $total = 0;
                                    // Calcula el total de la cesta
                                    foreach ($cesta as $producto) {
                                        $total += $producto['precio_producto']*$producto['cantidad'] ;
                                    }
                                    if (!empty($producto['descuento_oferta'])){
                                        $totalRebajado = $total*(1-$producto['descuento_oferta']/100);
                                    }
                                    if (!empty($producto['descuento_oferta'])){
                                        echo number_format($totalRebajado, 2, ',', '.');
                                    }else{
                                        echo number_format($total, 2, ',', '.');
                                    }
                                    ?> €</p>
                                </div>
                                <div class="ahorrado">
                                <?php if ($producto['descuento_oferta']): ?>
                                    <p class="ahorrado-verde">
                                        <?= 'Has ahorrado ' . number_format($total - $totalRebajado, 2, ',', '.') . '€' ?>
                                    </p>
                                <?php endif; ?>
                                    <p>* IVA incluido</p>
                                </div>
                            </div>
                            <!-- Botón para proceder con la compra -->
                            <a href="?url=comprar"><button type="submit">Tramitar pedido</button></a>                                    
                        </div>
                        <div class="tramitar-metodos">
                            <img class="excelente" src="views/img/icons/excelente.webp" alt="">
                            <p>Aceptamos diversos métodos de pago</p>
                            <img class="pagos" src="views/img/icons/metodos-pago.webp" alt="">
                        </div>
                    </aside>
                </div>
            <?php
            } else { ?>
                <!-- Mensaje si la cesta está vacía -->
                <div class="cesta-vacia">
                    <h2>Tu cesta está vacía</h2>
                    <p>Sigue comprando en <a href="?url=index">Mammoth's Kitchen</a> o visita tu <a href="">lista de favoritos</a>.</p>
                </div>
            <?php } ?>
        </section>        
    </main>
    <footer>
        <?php
            include "footer/footer.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>