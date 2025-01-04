<script src="api/headerCantidad.js"></script>
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
                <div class="btn-group" id="userMenu">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="menuButton">
                        <span id="menuText">Hola, identifícate</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="menuDropdown">
                        <li id="loginMenu">
                            <a href="?url=login" class="dropdown-item btn-iniciar" type="button">Iniciar sesión</a>
                        </li>
                        <hr id="divider">
                        <li id="registerMenu">
                            <p class="dropdown-item btn-nuevo-cliente"><strong>¿Nuevo cliente?</strong><a href="?url=registro"> Crea tu cuenta</a></p>
                        </li>
                        <!-- Aquí se agregarán dinámicamente los elementos del usuario logueado -->
                    </ul>
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
            <a href="?url=finalizar" class="count-productos">                
                <img class="icon" src="views/img/icons/cart.svg" alt="">
                <span id="cantidad-productos" style="display: inline;"></span>
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
