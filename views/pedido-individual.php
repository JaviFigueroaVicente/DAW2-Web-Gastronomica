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
            include_once "views/headers/header.php";
        ?>
    </header>
    <main class="cuenta">
        <!-- Sección principal donde se muestran los detalles de un pedido -->
        <section class="cuenta-section">
            <!-- Barra de navegación (Breadcrumbs) para mostrar el camino actual -->
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?url=cuenta">Mi cuenta</a></li> <!-- Enlace a la página principal de la cuenta -->
                    <li class="breadcrumb-item"><a href="?url=cuenta/mis-pedidos">Mis pedidos</a></li> <!-- Enlace a la página de "Mis pedidos" -->
                    <li class="breadcrumb-item active"><?= number_format($_GET['id_pedido'])?></li> <!-- Muestra el identificador del pedido actual en la barra de navegación -->
                </ol>
            </nav>
            <div>
                <h1>Detalles del pedido</h1> <!-- Título de la sección de detalles del pedido -->
            </div>          
            <div>
                <!-- Tabla para mostrar los productos del pedido individual -->
                <table class="table table-striped tabla-productos-pedido">                    
                    <thead>
                        <tr>
                            <!-- Encabezados de la tabla de productos -->
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio unitario</th>
                            <th scope="col">Precio total</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iteración sobre los productos del pedido y visualización en la tabla -->
                        <?php foreach ($pedidoIndividual as $producto): ?>
                            <tr>
                                <!-- Columna del producto con la foto, nombre, tamaño y referencia -->
                                <th scope="row" class="actualizar-direction producto-pedido-foto">
                                    <div class="card card-finalizar">
                                        <!-- Enlace al detalle del producto -->
                                        <a href="?url=productos/producto-individual&id=<?=$producto['id_producto']?>">
                                            <img src="data:image/webp;base64,<?= base64_encode($producto['foto_producto']) ?>" class="card-img-top" alt="Imagen del producto">
                                        </a>
                                        <div class="card-body">
                                            <!-- Nombre del producto con enlace al detalle del producto -->
                                            <h5><a href="?url=productos/producto-individual&id=<?=$producto['id_producto']?>"><?=$producto['nombre_producto']?></a></h5>
                                            <!-- Muestra el tamaño del producto -->
                                            <p class="card-text texto-tamaño comment">Tamaño: <?= $producto['tamaño_producto']?></p>    
                                            <div class="producto-borrar">
                                                <!-- Muestra la referencia del producto -->
                                                <p class="card-text texto-cantidad comment">Referencia: <?= $producto['id_producto'] ?></p>                                      
                                            </div>
                                        </div>                                      
                                    </div> 
                                </th>
                                <!-- Muestra la cantidad de productos -->
                                <td><?= number_format($producto['cantidad_producto']) ?></td>
                                <!-- Muestra el precio unitario del producto -->
                                <td><?= number_format($producto['precio_producto'], 2, ',', '.' ) ?> €</td>
                                <!-- Muestra el precio total del producto (precio unitario * cantidad) -->
                                <td><?= number_format(($producto['precio_producto']*$producto['cantidad_producto']), 2, ',', '.' ) ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> 
        </section>  
    </main>
    <footer>
        <?php
            include_once "views/footer/footer.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>