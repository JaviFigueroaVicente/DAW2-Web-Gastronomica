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
    <title>Producto</title>
</head>
<body>
    <header>
        <?php
            include 'views/headers/header.php';
        ?>
    </header>
    <main>
        <section class="producto-individual-section row">
            <div class="col-lg-8">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?url=productos">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="">Hamburguesas</a></li>
                    </ol>
                </nav>               
                <div class="gallery-container">
                    <div class="thumbnails">
                        <div class="thumbnail active"><img src="views/img/banners/comida1.webp" alt="Bike Image 1"></div>
                        <div class="thumbnail"><img src="views/img/banners/comida2.webp" alt="Bike Image 2"></div>
                        <div class="thumbnail"><img src="views/img/banners/comida3.webp" alt="Bike Image 3"></div>
                        <div class="thumbnail"><img src="views/img/banners/comida4.webp" alt="Bike Image 4"></div>
                        <div class="thumbnail"><img src="views/img/banners/comida5.webp" alt="Bike Image 5"></div>
                    </div>
                    <div class="main-image">
                        <span class="discount-badge">-50%</span>
                        <img src="views/img/banners/comida1.webp" alt="Imagen Principal">
                    </div>
                    
                </div>
                 
            </div>
            <div class="col-lg-4">
                <div class="header-producto">
                    <strong><a href="">Hamburguesa</a></strong>
                    <h1>Hamburguesa de queso</h1>
                </div>
                <div>
                    <div class="header-precios">
                        <span class="rebajado">489,00€</span>
                        <span class="precio-antiguo">230,00€</span>
                    </div>
                </div>
                <div class="entrega-estimada">
                    <img src="views/img/icons/camion_verde.svg" alt="">
                    <span>Entrega estimada 6 dic. 2024</span>                    
                </div>
                <div class="editar-producto">
                    <div class="tamaño">
                        <p id="selected-size">Tamaño: S</p>
                        <ul class="size-selector">
                            <li>
                                <input type="radio" id="size-s" name="size" value="S" checked>
                                <label for="size-s">S</label>
                            </li>
                            <li>
                                <input type="radio" id="size-m" name="size" value="M">
                                <label for="size-m">M</label>
                            </li>
                            <li>
                                <input type="radio" id="size-l" name="size" value="L">
                                <label for="size-l">L</label>
                            </li>
                            <li>
                                <input type="radio" id="size-xl" name="size" value="XL">
                                <label for="size-xl">XL</label>
                            </li>
                        </ul>
                    </div>
                    <div class="cantidad">
                        <p>Cantidad:</p>
                        <div class="modify">
                            <div class="modificar-producto">
                                <button type="button">-</button>
                                <input type="text" value="1">
                                <button type="button">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botones">
                    <button class="agregar-cesta" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <img src="views/img/icons/cart_white.svg" alt="">Añadir a la cesta
                    </button>           
                    <button class="agregar-favoritos" type="button">
                        <img src="views/img/icons/favourite_grey.svg" class="favorito-icon" alt="Favorito no seleccionado">
                        <span class="favorito-text">Añadir a favoritos</span>
                    </button>                
                </div>                
            </div>
            <div class="desplegable-cesta offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <div>                        
                        <img src="views/img/icons/check_circle_green.svg" alt="">          
                        <span>¡Producto añadido a la cesta!</span>              
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="card card-finalizar">
                        <a href=""><img src="views/img/banners/carne.webp" alt="..." class="card-img-top"></a>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text texto-tamaño">Tamaño: normal</p>
                            <p class="card-text texto-entrega">Entrega estimada 21:30h 25 oct</p>
                            <div class="modificar-producto">
                                <button type="button">-</button>
                                <input type="text" value="1">
                                <button type="button">+</button>
                            </div>                            
                        </div>
                        <div class="producto-borrar">     
                            <p class="rebajado">123,00€</p>                       
                            <p class="precio-antiguo">326,00€</p>
                        </div>                        
                    </div>
                    <div class="sumario">                            
                        <p><strong>Mi cesta: </strong>(1 artículo)</p>
                        <p>Subtotal:<strong> 123,00€</strong></p>                            
                    </div>
                    <div class="botones-cesta">
                        <button class="cesta-compra" type="button">Ver mi cesta</button>
                        <button class="continuar-compra" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Seguir comprando</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?=
            include 'views/footer/footer.php';
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/galeria-producto.js" type="text/javascript"></script> 
    <script src="views/js/producto-individual.js"></script>
</body>
</html>