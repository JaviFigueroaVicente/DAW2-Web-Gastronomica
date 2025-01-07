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
    <link rel="icon" href="views/img/icons/icono.svg" type="image/x-icon">  
    <title>Mammoth's Kitchen</title>  
</head>
<body>
    <header>
        <?php
            include_once "views/headers/header.php";
        ?>
    </header>
    <main class="cuenta">
        <!-- Sección principal de la cuenta del usuario -->
        <section class="cuenta-section">
            <!-- Barra de navegación de migas de pan (breadcrumbs) para mostrar la ubicación actual del usuario -->
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?url=cuenta">Mi cuenta</a></li> <!-- Enlace a la página principal de la cuenta -->
                    <li class="breadcrumb-item">Mis pedidos</li> <!-- Página actual -->
                </ol>
            </nav>
            <div>
                <h1>Mis pedidos</h1> <!-- Título de la sección -->
            </div>          
            <div>
                <!-- Tabla que muestra los detalles de los pedidos del usuario -->
                <table class="table table-striped tabla-productos-pedido">                    
                    <thead>
                        <tr>
                            <!-- Encabezados de las columnas de la tabla -->
                            <th scope="col">Identificador Pedido</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Precio Total</th>
                            <th scope="col">Tipo de pago</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Factura</th>
                            <th scope="col">Detalles del pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Se iteran los pedidos del usuario y se muestran en la tabla -->
                        <?php foreach ($pedidosUser as $pedido): ?>
                            <tr>
                                <!-- Muestra el identificador del pedido -->
                                <th scope="row"><?= number_format($pedido['id_pedido']) ?></th>
                                <!-- Muestra la fecha del pedido, formateada como día/mes/año -->
                                <td><?= date('d/m/Y', strtotime($pedido['fecha_pedido'])) ?></td>
                                <!-- Muestra el precio total del pedido, formateado a dos decimales -->
                                <td><?= number_format($pedido['precio_pedido'], 2) ?> €</td>
                                <!-- Muestra el método de pago utilizado en el pedido -->
                                <td><?= $pedido['metodo_pago'] ?></td>
                                <!-- Muestra el estado actual del pedido -->
                                <td><?= $pedido['estado_pedido'] ?></td>
                                <!-- Enlace para solicitar la factura del pedido -->
                                <td><a href="">Pedir Factura</a></td>
                                <!-- Enlace para ver los detalles completos del pedido -->
                                <td><a href="?url=cuenta/mis-pedidos/detalles-pedido&id_pedido=<?= $pedido['id_pedido']?>">Ver detalles del pedido</a></td>
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