<?php
session_start(); 

header('Content-Type: text/html; charset=UTF-8');


$url = $_GET['url'] ?? 'index';



switch ($url) {
    case 'index':
        include_once "controllers/indexController.php"; 
        $controller = new IndexController();
        $controller->index();  
        break;

    case 'admin':
        include_once "controllers/apiController.php";
        $controller = new ApiController();
        $controller->admin();
        break;

    case 'api':
        include_once "controllers/apiController.php";
        $controller = new ApiController();

        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'productos':
                $controller->getProductos();
                break;

            case 'producto-individual':
                $controller->getProductoIndividual();
                break;

            case 'update-producto':
                $controller->updateProducto();
                break;
                
            case 'delete-producto':
                $controller->deleteProducto();
                break;

            case 'create-producto':
                $controller->createProducto();
                break;
            
            case 'pedidos':
                $controller->getPedidos();
                break;
            
            case 'pedido-individual':
                $controller->getPedidoIndividual();
                break;
            
            case 'update-pedido':
                $controller->updatePedido();
                break;
            
            case 'delete-pedido':
                $controller->deletePedido();
                break;

            
            case 'create-pedido':
                $controller->createPedido();
                break;

            case 'users':
                $controller->getUsers();
                break;

            case 'user-individual':
                $controller->getUserIndividual();
                break;
            
            case 'update-user':
                $controller->updateUser();
                break;

            case 'create-user':
                $controller->createUser();
                break;

            case 'delete-user':
                $controller->deleteUser();
                break;

            case 'tramitar-pedido':
                $controller->tramitarPedido();
                break;

            case 'login':
                $controller->login();
                break;

            case 'cupones':
                $controller -> aplicarCupon();
                break;
            
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
        break;

    case 'productos':
        include_once "controllers/productoController.php";
        $controller = new ProductoController();
    
        if (isset($_GET['categoria'])) {
            $controller->productosByCategoria();
        } elseif (isset($_GET['oferta'])) {
            $controller->productosByOferta();
        } else {
            $controller->productos();
        }
        
        break;

    case 'productos/producto-individual':
        include_once "controllers/productoController.php";
        $controller = new ProductoController();
        $controller->productoIndividual();
        break;
    
    case 'finalizar':
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->finalizar();  
        break; 

    case 'comprar':
        include_once "controllers/pedidoController.php";
        $controller = new PedidoController();
        $controller->comprar();
        break;

    case 'cuenta/mis-pedidos':
        include_once "controllers/pedidoController.php";
        $controller = new PedidoController();
        $controller-> misPedidos();
        break;

    case 'cuenta/mis-pedidos/detalles-pedido':
        include_once "controllers/pedidoController.php";
        $controller = new PedidoController();
        $controller-> pedidoInidividual();
        break;
    
    case 'login':
        include_once "controllers/userController.php";
        $controller = new UserController();
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
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller -> registro();
        break;

    case 'registro/create':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->create(); 
        break;
    
    case 'cuenta':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller -> cuenta();
        break;
    
    case 'datos-personales':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->datosPersonales();
        break;
        
    case 'datos-personales/update-perfil':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->actualizarPerfil();
        break;
    
    case 'datos-acceso':
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->datosAcceso();
        break;

    case 'datos-acceso/update-password':
        include_once "controllers/userController.php";
        $controller = new UserController();
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
