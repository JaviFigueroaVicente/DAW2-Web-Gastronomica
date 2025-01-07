<?php
session_start();  // Inicia la sesión

header('Content-Type: text/html; charset=UTF-8'); 
$protectedRoutes = ['finalizar', 'comprar', 'admin', 'api', 'cuenta', 'datos-personales', 'datos-personales','datos-acceso'];  // Rutas protegidas que requieren autenticación

$url = $_GET['url'] ?? 'index';  // Obtiene la URL de la solicitud o usa 'index' por defecto

// Verifica si la ruta solicitada está protegida y si no hay usuario autenticado
if (in_array($url, $protectedRoutes) && !isset($_SESSION['user_id'])) {
    header("Location: ?url=login");  // Redirige al login si no está autenticado
    exit; 
}

// Controla las rutas según el valor de $url
switch ($url) {
    case 'index':  // Página de inicio
        include_once "controllers/indexController.php"; 
        $controller = new IndexController();
        $controller->index(); 
        break;

    case 'admin':  // Ruta del panel de administración
        include_once "controllers/apiController.php";
        $controller = new ApiController();
        $controller->admin();
        if($_SESSION['user_rol'] == 0 & $url == 'admin'){  // Redirige si no es un administrador
            header("Location: ?url=index");
        }
        break;

    case 'api':  // Ruta de la API para gestionar productos, pedidos, usuarios, etc.
        include_once "controllers/apiController.php";
        $controller = new ApiController();

        $action = $_GET['action'] ?? '';  // Obtiene la acción específica a realizar

        // Verifica las acciones posibles y las ejecuta
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
            case 'logs':
                $controller->getLogs();
                break;
            case 'insert-log':
                $controller->insertLog();
                break;
            default:
                http_response_code(400);  // Error de acción no válida
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
        break;

    // Ruta para gestionar productos
    case 'productos':
        include_once "controllers/productoController.php";
        $controller = new ProductoController();

        // Verifica si hay una búsqueda o una categoría para filtrar los productos
        if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $controller->productosByBusqueda();
        } elseif (isset($_GET['categoria'])) {
            $controller->productosByCategoria();
        } else {
            $orden = isset($_GET['ordenar']) ? $_GET['ordenar'] : null;
            $controller->productos($orden);
        }
        break;

    case 'productos/producto-individual':  // Detalle de un producto individual
        include_once "controllers/productoController.php";
        $controller = new ProductoController();
        $controller->productoIndividual();
        break;

    // Otras rutas relacionadas con la cesta, compra y cuenta de usuario
    case 'finalizar': 
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->finalizar();  
        break; 

    case'añadir-cesta':  // Añadir producto a la cesta
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->añadirCesta();
        break;

    case 'finalizar/eliminar-producto-cesta':  // Eliminar producto de la cesta
        include_once "controllers/cestaController.php";
        $controller = new CestaController();
        $controller->eliminarProductoCesta();
        break;

    // Otras acciones de finalizar y modificar cesta
    case 'comprar':  
        include_once "controllers/pedidoController.php";
        $controller = new PedidoController();
        $controller->comprar();
        break;

    case 'comprar/tramitar-pedido':  // Crear un pedido
        include_once "controllers/pedidoController.php";
        $controller = new PedidoController();
        $controller->crearPedido();
        break;

    // Rutas para la cuenta de usuario
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
    
    case 'login':  // Ruta para la página de login
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->login();
        break;
    
    case 'login/entrar':  // Procesar el login
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->entrar(); 
        break;

    case 'logout':  // Cerrar sesión
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->logout();
        break;

    case 'registro':  // Ruta para la página de registro
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->registro();
        break;

    case 'registro/create':  // Procesar el registro de un nuevo usuario
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->create(); 
        break;
    
    case 'cuenta':  // Ruta para la cuenta de usuario
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->cuenta();
        break;
    
    case 'datos-personales':  // Ruta para ver los datos personales
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->datosPersonales();
        break;
        
    case 'datos-personales/update-perfil':  // Ruta para actualizar el perfil personal
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->actualizarPerfil();
        break;
    
    case 'datos-acceso':  // Ruta para los datos de acceso
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->datosAcceso();
        break;

    case 'datos-acceso/update-password':  // Ruta para cambiar la contraseña
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->cambiarContra();
        break;

    case 'datos-acceso/update-password/cambiar':  // Ruta para actualizar la contraseña
        include_once "controllers/userController.php";
        $controller = new UserController();
        $controller->updateContra();
        break;
    
    default:  // Ruta no encontrada
        echo "Página no encontrada.";
        break;
}
?> 
