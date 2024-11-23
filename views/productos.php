<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../views/css/styles.css">
    <title>Productos</title>
</head>
<body>
    <header>
        <?php
            include("headers/header.php");
        ?>
    </header>
    <main class="productos">
        <aside class="menu-lateral">
            <ul class="menu-categorias">
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#categorias" aria-expanded="true" aria-controls="categorias">
                        + Categorías
                    </button>
                    <ul id="categorias" class="menu-subitems collapse">
                        <li>Comida baja en hidratos</li>
                        <li>Comida alta en proteínas</li>
                        <li>Comida sin calorías</li>
                        <li>Comida tipo Fitfood</li>
                        <li>Comida sin grasas</li>
                    </ul>
                </li>
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#ingredientes" aria-expanded="true" aria-controls="ingredientes">
                        + Ingredientes
                    </button>
                    <ul id="ingredientes" class="menu-subitems collapse">
                        <li>Carnes</li>
                        <li>Pescados</li>
                        <li>Pasta</li>
                        <li>Legumbres</li>
                        <li>Frutos secos</li>
                        <li>Lácteos</li>
                        <li>Frutas y verduras</li>
                        <li>Otros alimentos</li>
                    </ul>
                </li>
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#ofertas" aria-expanded="false" aria-controls="ofertas">
                        + Ofertas
                    </button>
                    <ul id="ofertas" class="menu-subitems collapse">
                        <li>Descuentos del día</li>
                        <li>Promociones especiales</li>
                    </ul>
                </li>
            </ul>
        </aside>
        <section class="lista-productos">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="">Library</a></li>
                </ol>
            </nav>
            <h1>Todas las recetas</h1>
            <div class="productos-list">
                <div class="productos-ordenar">
                    <p>125 productos</p>
                    <select>
                        <option selected>Ordenar</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>  
            <div class="container text-center card-productos">
                <div class="row">
                    <?php
                    foreach ($productos as $producto){
                        $fotoBase64 = base64_encode($producto -> getFoto_producto());
                    ?>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="data:image/webp;base64,<?= $producto -> getFoto_producto()?>" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title"><?= $producto -> getNombre_producto() ?></a>
                                <p class="card-text"><?= $producto -> getPrecio_producto() ?>€</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="../views/img/banners/producto1.webp" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title">Card title</a>
                                <p class="card-text">3.234,43€</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="../views/img/banners/producto1.webp" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title">Card title</a>
                                <p class="card-text">3.234,43€</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="../views/img/banners/producto1.webp" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title">Card title</a>
                                <p class="card-text">3.234,43€</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="../views/img/banners/producto1.webp" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title">Card title</a>
                                <p class="card-text">3.234,43€</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-img-container">
                                <a href="#">
                                    <img src="../views/img/banners/producto1.webp" class="card-img-top" alt="Producto 1">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="#" class="card-title">Card title</a>
                                <p class="card-text">3.234,43€</p>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </section>
    </main>
    <footer>
        <?php
            include("footer/footer.php");
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../views/js/menu-lateral.js"></script>
</body>
</html>