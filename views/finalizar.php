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
    <script src="api/cestaIntegration.js"></script>
    <title>Finalizar</title>
</head>
<body>
    <header>
        <?php
            include_once "headers/header.php";
        ?>    
    </header>
    <main>
        <section class= "cesta">
            <h2>Mi cesta</h2>
            <p id="total-articulos">(0 artículos)</p>
        </section>        
        <section class="productos-finalizar" id="productos-cesta">
            <div class="finalizar-izquierda">
                <div class="productos-cesta" id="productos-lista">
                    <!-- Aquí se generarán las tarjetas de productos -->
                </div>
                <div class="cesta-bottom">
                    <div class="d-flex align-items-center">
                        <img src="views/img/icons/etiqueta.svg" alt="">
                        <div>
                            <p class="cupon">¿Tienes un cupón?</p>
                            <form id="form-cupon">
                                <label for="cupon_code"></label>
                                <input name="cupon_code" type="text" placeholder="Código">
                                <button type="submit">Aplicar</button>
                            </form>
                        </div>
                    </div>
                    <p class="iva">
                        * En las ventas fuera de la UE no se repercutirá IVA (21%), no obstante el sistema aduanero aplicará las cargas impositivas correspondientes...
                    </p>
                </div>
            </div>
            <div class="tramitar-pedido">
                <aside class="sticky-top">
                    <div class="tramitar-menu">
                        <div class="tramitar-subtotal">
                            <div>
                                <p>Subtotal</p>
                                <p class="precio-subtotal" id="subtotal">0,00 €</p>
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
                                <p class="precio-total" id="total">0,00 €</p>
                            </div>
                            <div class="ahorrado" id="ahorro">
                                <!-- Se mostrará el ahorro si aplica -->
                            </div>
                        </div>
                        <a href="?url=comprar"><button type="submit">Tramitar pedido</button></a>
                    </div>
                    <div class="tramitar-metodos">
                        <img class="excelente" src="views/img/icons/excelente.webp" alt="">
                        <p>Aceptamos diversos métodos de pago</p>
                        <img class="pagos" src="views/img/icons/metodos-pago.webp" alt="">
                    </div>
                </aside>
            </div>
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