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
        <form action="?url=añadir-cesta" method="post">
            <section class="producto-individual-section row">            
                <div class="col-lg-8">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="?url=productos">Productos</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $productoIndividual['nombre_producto'] ?></li>
                        </ol>
                    </nav>               
                    <div class="gallery-container">
                        <div class="thumbnails">
                            <div class="thumbnail active"><img src="<?=$productoIndividual['foto_producto']?>" alt=""></div>                        
                        </div>
                        <div class="main-image">
                            <img src="<?=$productoIndividual['foto_producto']?>" alt="Imagen Principal">
                        </div>                    
                    </div>                 
                </div>
                <div class="col-lg-4">                    
                    <div class="header-producto">
                        <strong><a href="?url=productos&categoria=<?= number_format($categoriaId['id_categoria_producto']) ?>"><?= $categoriaId['nombre_categoria_producto'] ?></a></strong>
                        <h1><?=$productoIndividual['nombre_producto']?></h1>
                    </div>
                    <div>
                        <div class="header-precios">
                            <span class="rebajado" data-precio="<?=number_format($productoIndividual['precio_producto'], 2, ',', '.')?>">€</span>
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
                                    <input type="radio" id="size-s" name="tamaño" value="S" checked>
                                    <label for="size-s">S</label>
                                </li>
                                <li>
                                    <input type="radio" id="size-m" name="tamaño" value="M">
                                    <label for="size-m">M</label>
                                </li>
                                <li>
                                    <input type="radio" id="size-l" name="tamaño" value="L">
                                    <label for="size-l">L</label>
                                </li>
                                <li>
                                    <input type="radio" id="size-xl" name="tamaño" value="XL">
                                    <label for="size-xl">XL</label>
                                </li>
                            </ul>
                        </div>
                        <div class="cantidad">
                            <p>Cantidad:</p>
                            <div class="modify">
                                <input class="stock-producto" type="text" hidden value="<?=number_format($productoIndividual['stock_producto'])?>">
                                <div class="modificar-producto">
                                    <button type="button" class="btn-reducir">-</button>
                                    <input type="text" <?php if($productoIndividual['stock_producto'] == 0){ echo 'value="0"'; }else{ echo 'value="1"';} ?> class="cantidad-productos">
                                    <button type="button" class="btn-aumentar">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="botones">
                        <button class="agregar-cesta" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" <?php if($productoIndividual['stock_producto'] == 0){ echo 'disabled'; } ?>>
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
                            <a href=""><img src="<?=$productoIndividual['foto_producto']?>" alt="..." class="card-img-top"></a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$productoIndividual['nombre_producto']?></h5>
                                <p class="card-text texto-tamaño">Tamaño: normal</p>
                                <p class="card-text texto-entrega">Entrega estimada 21:30h 25 oct</p>
                                <div class="modificar-producto">
                                    <input name="producto_id" type="text" hidden value="<?=number_format($productoIndividual['id_producto'], 2, ',', '.')?>">
                                    <input class="stock-producto" type="text" hidden value="<?=number_format($productoIndividual['stock_producto'], 2, ',', '.')?>">
                                    <button type="button" class="btn-reducir">-</button>
                                    <input name="cantidad" type="text" value="1" class="cantidad-productos">
                                    <button type="button" class="btn-aumentar">+</button>
                                </div>                            
                            </div>
                            <div class="producto-borrar header-precios">     
                                <span class="rebajado" data-precio="<?=number_format($productoIndividual['precio_producto'], 2, ',', '.')?>">€</span>                       
                            </div>                        
                        </div>
                        <div class="sumario">                            
                            <p><strong>Mi cesta: </strong><span class="num-articulos">(1 artículo)</span></p>
                            <p>Subtotal:<strong><span class="subtotal">€</span></strong></p>                            
                        </div>
                        <div class="botones-cesta">
                            <button class="cesta-compra" type="submit" >Ver mi cesta</button>
                            <button class="continuar-compra" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Seguir comprando</button>
                        </div>                    
                    </div>                    
                </div>            
            </section>
        </form>
        <section class="footer-productos-section col-6">
            <div class="descripcion-producto">
                <h2>Características <?=$productoIndividual['nombre_producto']?></h2>
                <p class="caracteristicas-producto"><?=$productoIndividual['descripcion_producto']?></p>
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