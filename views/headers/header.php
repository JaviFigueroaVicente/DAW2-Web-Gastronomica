<div class="header_top">
    <ul>
        <li>
            <a href="#">
                <img src="views/img/icons/help.svg" alt="">
                <span>Centro de ayuda</span>
            </a>
        </li>
        <li>
            <a href="#">
                <img src="views/img/icons/location.svg" alt="">
                <span>Puntos de venta</span>
            </a>
        </li>
        <li>
            <a href="#">
                <img src="views/img/icons/clock.svg" alt="">
                <span>Cita prévia</span>
            </a>
        </li>      
    </ul>
</div>
<div class="header-main">
    <a href="?url=index">
        <img id="logo" src="views/img/icons/logo.webp" alt="">
    </a>
    <div class="buscador">
        <form action="view" method="post">
            <input type="text" name="" id="" placeholder="Encuentra lo que deseas...">
            <img class="icon" src="views/img/icons/buscar.svg" alt="">
        </form>
    </div>
    <div id="iconos">
        <div class="sesiones">
            <div class="inicio-sesion">
                <img class="icon" src="views/img/icons/profile.svg" alt="">
                <div class="btn-group">
                    <?php
                        if(empty($_SESSION['user_id'])){?>
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>Hola, identifícate</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="?url=login" class="dropdown-item btn-iniciar" type="button">Iniciar sesión</a>
                                </li>
                                <hr>
                                <li>
                                    <p class="dropdown-item btn-nuevo-cliente"><strong>¿Nuevo cliente?</strong><a href="?url=registro"> Crea tu cuenta</a></p>
                                </li>
                            </ul>
                        <?php
                        }else{?>                           
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>Mi cuenta</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-log">
                                <li>
                                    <p class="dropdown-item nombre-desplegable">Hola <a href="?url=cuenta" ><?php echo $_SESSION['user_name'] ?></a></p>
                                </li>
                                <li class="ul-dropdown">
                                    <ul class="lista-dropdown">
                                        <li>
                                            <a class="a-log" href="?url=cuenta">Mi cuenta</a>
                                        </li>
                                        <li>
                                            <a class="a-log" href="?url=cuenta/mis-pedidos">Mis pedidos</a>
                                        </li>
                                        <li>
                                            <a class="a-log" href="">Atención al cliente</a>
                                        </li>
                                        <?php
                                            if($_SESSION['user_rol'] == '1'){
                                        ?>
                                                <li>
                                                    <a class="a-log" href="?url=admin">Administración</a>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <li>
                                    <a class="a-log" href="?url=logout">Cerrar sesión</a>
                                </li>
                            </ul>
                        <?php } ?>
                </div>
            </div>
        </div>
        <div>
            <a href="">
                <div>
                    <img class="icon" src="views/img/icons/favourite.svg" alt="">
                </div>
            </a>
        </div>
        <div class="carrito-icon"> 
            <a href="?url=finalizar">                
                <img class="icon" src="views/img/icons/cart.svg" alt="">
                <?php
                if(isset($_SESSION['user_id'])){
                    include_once "models/cesta/CestaDAO.php";
                    $totalCesta = CestaDAO::countTotal($_SESSION['user_id']);
                    if($totalCesta > 0){ ?>
                    <span><?php echo number_format($totalCesta);?></span>
                <?php } } ?>                         
            </a>
        </div>
    </div>
</div>
<div id="header-nav">
    <nav class="navbar navbar-expand-lg"> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMenu" aria-controls="navbarTogglerMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>               
        <ul class="nav justify-content-between collapse navbar-collapse me-auto" id="navbarTogglerMenu">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="?url=productos">RECETAS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=productos">MENÚ DEL DÍA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=productos&categoria=2">FIT FOOD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=productos">PLATOS COMBINADOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=productos">CREACIÓN DE PLATOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=productos">INGREDIENTES</a>
            </li>
        </ul>          
    </nav>            
</div> 