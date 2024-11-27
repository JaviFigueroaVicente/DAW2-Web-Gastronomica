<?php
$url = $_GET['url'] ?? '';


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
    
    case 'finalizar':
        include_once "controllers/finalizarController.php";
        $controller = new FinalizarController();
        $controller->finalizar();  
        break; 

    case 'login':
        include_once "controllers/loginController.php";
        $controller = new LoginController();
        $controller -> login();
        break;

    case 'registro':
        include_once "controllers/registroController.php";
        $controller = new RegistroController();
        $controller -> registro();
        break;
    

    default:
        echo "Página no encontrada.";
        break;
}
?>
