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
    <script src="api/userAPI.js" defer></script>
    <script src="api/pedidosAPI.js" defer></script>
    <script src="api/productosAPI.js"></script>
</head>
<body>
    <header>
        <?php
            include_once "views/headers/header.php";
        ?>
    </header>
    <main class="admin-main">
        <section class= "cesta">
            <h2>Administrar Web</h2>            
        </section>   
        <section class="row">     
            <aside class="menu-lateral admin-lateral col-lg-2">
                <nav class="nav flex-column">
                    <a class="nav-link active" data-section="productos" href="">Productos</a>
                    <a class="nav-link" href="" data-section="pedidos">Pedidos</a>
                    <a class="nav-link" href="" data-section="usuarios">Usuarios</a>
                </nav>
            </aside>
            <div id="content-container" class="col-lg-7">

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