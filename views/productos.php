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
                <!-- Menú de categorías colapsable -->
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#categorias" aria-expanded="true" aria-controls="categorias">
                        + Categorías
                    </button>
                    <ul id="categorias" class="menu-subitems collapse">
                        <li><a href="?url=productos">Todas las categorías</a></li>
                        <?php
                        // Se generan las categorías dinámicamente desde el array $categoriasProducto
                        foreach ($categoriasProducto as $categoria) {
                            echo '<li><a href="?url=productos&categoria='.$categoria['id_categoria_producto'].'">' . ucfirst($categoria['nombre_categoria_producto']) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <!-- Menú de ingredientes colapsable -->
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#ingredientes" aria-expanded="true" aria-controls="ingredientes">
                        + Ingredientes
                    </button>
                    <ul id="ingredientes" class="menu-subitems collapse">
                        <!-- Lista estática de ingredientes -->
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
                <!-- Menú de ofertas colapsable -->
                <li class="menu-item">
                    <button class="menu-header" type="button" data-bs-toggle="collapse" data-bs-target="#ofertas" aria-expanded="false" aria-controls="ofertas">
                        + Ofertas
                    </button>
                    <ul id="ofertas" class="menu-subitems collapse">
                        <li><a href="?url=productos">Todas las ofertas</a></li>
                        <?php
                            // Se generan las ofertas dinámicamente desde el array $ofertas
                            foreach ($ofertas as $oferta) {
                                echo '<li><a href="?url=productos&oferta=' . $oferta->getId_oferta() . '">' . ucfirst($oferta->getNombre_oferta()) . '</a></li>';
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </aside>

        <section class="lista-productos">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?url=productos">Productos</a></li>
                    <?php 
                        // Muestra las migas de pan basadas en la URL
                        if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
                            echo '<li class="breadcrumb-item active" aria-current="page">Búsqueda: "' . htmlspecialchars($_GET['busqueda']) . '"</li>';
                        } elseif (isset($_GET['categoria'])) {
                            echo '<li class="breadcrumb-item active" aria-current="page">' . ucfirst($categoriaId['nombre_categoria_producto']) . '</li>';
                        }
                    ?>
                </ol>
            </nav>

            <h1>
            <?php 
                // Título dinámico según los filtros de la URL
                if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
                    echo "Resultados para: \"" . htmlspecialchars($_GET['busqueda']) . "\"";
                } elseif (isset($_GET['categoria'])) {
                    echo ucfirst($categoriaId['nombre_categoria_producto']);
                } elseif (isset($_GET['oferta'])) {
                    echo ucfirst($oferta->getNombre_oferta());
                } else {
                    echo "Todos los productos";
                }
            ?>
            </h1>
            <div class="productos-list">
                <div class="productos-ordenar">
                    <p><?= $total_productos ?> productos</p>
                    <form method="get" action="">
                        <input type="hidden" name="url" value="productos">

                        <!-- Mantiene los parámetros de URL para categorías y ofertas -->
                        <?php if (isset($_GET['categoria'])): ?>
                            <input type="hidden" name="categoria" value="<?= htmlspecialchars($_GET['categoria']) ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['oferta'])): ?>
                            <input type="hidden" name="oferta" value="<?= htmlspecialchars($_GET['oferta']) ?>">
                        <?php endif; ?>

                        <!-- Selector de ordenación -->
                        <select name="ordenar" onchange="this.form.submit()">
                            <option value="" <?= !isset($_GET['ordenar']) ? 'selected' : '' ?>>Ordenar</option>
                            <option value="1" <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == '1') ? 'selected' : '' ?>>Nuevos primero</option>
                            <option value="2" <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == '2') ? 'selected' : '' ?>>Más caros</option>
                            <option value="3" <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == '3') ? 'selected' : '' ?>>Más baratos</option>
                            <option value="4" <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == '4') ? 'selected' : '' ?>>A-Z</option>
                            <option value="5" <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == '5') ? 'selected' : '' ?>>Z-A</option>
                        </select>
                    </form>
                </div>
            </div>  
            <div class="container text-center card-productos">
                <?php if (!empty($productos)): ?>
                    <div class="row">
                        <?php
                        // Muestra los productos en tarjetas, organizados en filas de tres productos
                        $count = 0;
                        foreach ($productos as $producto):
                            if ($count > 0 && $count % 3 === 0): ?>
                                </div>
                                <div class="row">
                            <?php endif; ?>
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-img-container">
                                        <a href="?url=productos/producto-individual&id=<?= htmlspecialchars($producto['id_producto']) ?>">
                                            <?php if ($producto['foto_producto']): ?>
                                                <img src="<?= $producto['foto_producto'] ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre_producto']) ?>">
                                            <?php else: ?>
                                                <img src="default-image.webp" class="card-img-top" alt="Producto sin imagen">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <a href="?url=productos/producto-individual&id=<?= htmlspecialchars($producto['id_producto']) ?>" class="card-title"><?= htmlspecialchars($producto['nombre_producto']) ?></a>
                                        <p class="card-text"><?= number_format($producto['precio_producto'], 2, ',', '.') ?>€</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $count++;
                        endforeach;
                        ?>
                    </div>
                <?php else: ?>
                    <p>No hay productos disponibles.</p>
                <?php endif; ?>            
            </div>
        </section>
    </main>
    <footer>
        <?php
            include("footer/footer.php");
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/menu-lateral.js"></script>
</body>
</html>