<?php
session_start(); 


$protectedRoutes = ['productos', 'finalizar'];


$url = $_GET['url'] ?? 'index';


if (in_array($url, $protectedRoutes) && !isset($_SESSION['user_id'])) {
    echo "No has iniciado sesión. <a href='?url=login'>Inicia sesión</a>";
    exit; 
}


switch ($url) {
    case 'index':
        include_once "controllers/indexController.php"; 
        $controller = new IndexController();
        $controller->index();  
        break;

    case 'productos':
        include_once "controllers/productoController.php";
        $controller = new ProductoController();
        $controller->productos();  
        break;  

    case 'productos/producto-individual':
        include_once "controllers/productoIndividualController.php";
        $controller = new ProductoIndividualController();
        $controller->productoIndividual();
        break;
    
    case 'finalizar':
        include_once "controllers/finalizarController.php";
        $controller = new FinalizarController();
        $controller->finalizar();  
        break; 

    case'añadir-cesta':
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->añadirCesta();
        break;

    case'finalizar/eliminar-producto-cesta':
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->eliminarProductoCesta();
        break;
    
    case 'finalizar/modificar-producto-cesta':
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->actualizarCantidadProductoCesta();
        break;

    case 'comprar':
        include_once "controllers/comprarController.php";
        $controller = new ComprarController();
        $controller->comprar();
        break;

    case 'comprar/tramitar-pedido':
        include_once "controllers/tramitarPedidoController.php";
        $controller = new TramitarPedidoController();
        $controller->crearPedido();
        break;

    
    
    case 'login':
        include_once "controllers/loginController.php";
        $controller = new LoginController();
        $controller -> login();
        break;
    
    case 'login/entrar': 
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->entrar(); 
        break;

    case 'logout':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller -> logout();
        break;

    case 'registro':
        include_once "controllers/registroController.php";
        $controller = new RegistroController();
        $controller -> registro();
        break;

    case 'registro/create':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->create(); 
        break;
    
    case 'cuenta':
        include_once "controllers/cuentaController.php";
        $controller = new CuentaController();
        $controller -> cuenta();
        break;
    
    case 'datos-personales':
        include_once "controllers/datosPersonalesController.php";
        $controller = new DatosPersonalesController();
        $controller->datosPersonales();
        break;
        
    case 'datos-personales/update-perfil':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->actualizarPerfil();
        break;
    
    case 'datos-acceso':
        include_once "controllers/datosAccesoController.php";
        $controller = new DatosAccesoController();
        $controller->datosAcceso();
        break;

    case 'datos-acceso/update-password':
        include_once "controllers/datosCambiarContraController.php";
        $controller = new DatosCambiarContraController();
        $controller->cambiarContra();
        break;

    case 'datos-acceso/update-password/cambiar':        
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->updateContra();
        break;
    
        
    default:
        echo "Página no encontrada.";
        break;
}
?>
