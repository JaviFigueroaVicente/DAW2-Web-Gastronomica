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

    default:
        echo "Página no encontrada.";
        break;
}
?>
