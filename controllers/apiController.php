<?php
include_once "config/dataBase.php"; 
include_once "models/logs/LogsDAO.php"; 

class ApiController {
    // Método que carga la vista del administrador
    public function admin() {
        include_once "views/admin.php";
    }

    // Obtener todos los productos
    public function getProductos() {
        include_once 'models/productos/ProductosDAO.php';
        $productos = ProductosDAO::getAll();  // Llamar al DAO para obtener los productos
        header('Content-Type: application/json');
        echo json_encode($productos);  // Devolver los productos en formato JSON
    }

    // Obtener un producto individual por ID
    public function getProductoIndividual() {
        include_once 'models/productos/ProductosDAO.php';
        if (isset($_GET['id'])) {  // Si se pasa un ID por GET
            $id = $_GET['id'];  
            $producto = ProductosDAO::getProductoIndividual($id); // Obtener producto por ID
            
            if ($producto) {
                echo json_encode($producto);  // Si el producto existe, devolverlo
            } else {
                echo json_encode(['error' => 'Producto no encontrado']);  // Si no se encuentra el producto
            }
        } else {
            echo json_encode(['error' => 'ID de producto no proporcionado']);  // Si no se pasa el ID
        }
    }
    
    // Actualizar un producto
    public function updateProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraemos los datos del producto
            $id = $_POST['id_producto'];
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion_producto'];
            $precio = $_POST['precio_producto'];
            $stock = $_POST['stock_producto'];
    
            // Procesar la foto del producto si se sube
            $foto_producto = null;
            if (isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {
                $foto_producto = file_get_contents($_FILES['foto_producto']['tmp_name']); // Leer el archivo en binario
            }
    
            // Actualizar el producto usando el DAO
            $resultado = ProductosDAO::updateProducto($id, $nombre, $descripcion, $precio, $stock, $foto_producto);
    
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si es exitoso, se devuelve éxito
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el producto.']);  // Si hay error
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }

    // Eliminar un producto
    public function deleteProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  // Si el método es DELETE
            // Leer los datos de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (isset($data['id_producto'])) {  // Verificar si se pasa el ID
                $id = $data['id_producto'];
    
                // Llamar al DAO para eliminar el producto
                $resultado = ProductosDAO::deleteProducto($id);
    
                if ($resultado) {
                    echo json_encode(['success' => true]);  // Si la eliminación es exitosa
                } else {
                    http_response_code(500);  // Error en el servidor
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el producto.']);
                }
            } else {
                http_response_code(400);  // Error de solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de producto no proporcionado.']);
            }
        } else {
            http_response_code(405);  // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    // Crear un nuevo producto
    public function createProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraer los datos del producto
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion_producto'];
            $precio = $_POST['precio_producto'];
            $stock = $_POST['stock_producto'];
            $id_categoria_producto = $_POST['id_categoria_producto'];
            $foto_producto = $_FILES['foto_producto'] ?? null;
    
            $rutaImagen = null;
            if ($foto_producto && $foto_producto['error'] === UPLOAD_ERR_OK) {
                $rutaImagen = file_get_contents($foto_producto['tmp_name']);  // Obtener la imagen
            }
    
            // Crear el producto en la base de datos
            $resultado = ProductosDAO::createProducto($nombre, $descripcion, $precio, $stock, $id_categoria_producto, $rutaImagen);
    
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si la creación es exitosa
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el producto.']);  // Si falla
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }

    // Pedidos

    public function getPedidos() {
        include_once 'models/pedidos/PedidoDAO.php';
        $pedidos = PedidoDAO::getAllPedidos();  // Obtener todos los pedidos
        header('Content-Type: application/json');
        echo json_encode($pedidos);  // Devolver en formato JSON
    }

    public function getPedidoIndividual() {
        include_once 'models/pedidos/PedidoDAO.php';
        if (isset($_GET['id'])) {  // Si se pasa un ID por GET
            $id = $_GET['id'];  
            $pedido = PedidoDAO::getPedidoById($id);  // Obtener pedido por ID

            if ($pedido) {
                echo json_encode($pedido);  // Si existe, devolverlo
            } else {
                echo json_encode(['error' => 'Pedido no encontrado']);  // Si no se encuentra
            }
        } else {
            echo json_encode(['error' => 'ID de pedido no proporcionado']);  // Si no se pasa el ID
        }
    }

    public function updatePedido() {
        include_once 'models/pedidos/PedidoDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraer los datos del pedido
            $idPedido = $_POST['id_pedido'];
            $fechaPedido = $_POST['fecha_pedido'];
            $estadoPedido = $_POST['estado_pedido'];
            $idUserPedido = $_POST['id_user_pedido'];
            $precioPedido = $_POST['precio_pedido'];
            $direccionPedido = $_POST['direccion_pedido'];
            $metodoPago = $_POST['metodo_pago'];
    
            // Actualizar el pedido usando el DAO
            $resultado = PedidoDAO::updatePedido($idPedido, $fechaPedido, $estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago);
    
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si es exitoso
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el pedido.']);  // Si falla
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }

    public function deletePedido() {
        include_once 'models/pedidos/PedidoDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  // Si el método es DELETE
            // Leer el cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (isset($data['id_pedido'])) {  // Verificar si se pasa el ID
                $id = $data['id_pedido'];
    
                // Llamar al DAO para eliminar el pedido
                $resultado = PedidoDAO::deletePedido($id);
    
                if ($resultado) {
                    echo json_encode(['success' => true]);  // Si la eliminación es exitosa
                } else {
                    http_response_code(500);  // Error interno
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el pedido.']);
                }
            } else {
                http_response_code(400);  // Error de solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de pedido no proporcionado.']);
            }
        } else {
            http_response_code(405);  // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    public function createPedido() {
        include_once 'models/pedidos/PedidoDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraer los datos del pedido
            $estadoPedido = $_POST['estado_pedido'];
            $idUserPedido = $_POST['id_user_pedido'];
            $precioPedido = $_POST['precio_pedido'];
            $direccionPedido = $_POST['direccion_pedido'];
            $metodoPago = $_POST['metodo_pago'];

            // Crear el pedido en la base de datos
            $resultado = PedidoDAO::createPedido($estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago);
            
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si la creación es exitosa
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el pedido.']);  // Si falla
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }
    
    // Usuarios

    public function getUsers() {
        include_once 'models/users/UserDAO.php';
        $usuarios = UserDAO::getAllUsers();  // Obtener todos los usuarios
        header('Content-Type: application/json');
        echo json_encode($usuarios);  // Devolverlos en formato JSON
    }

    public function getUserIndividual() {
        include_once 'models/users/UserDAO.php';
        if (isset($_GET['id'])) {  // Si se pasa un ID por GET
            $id = intval($_GET['id']); 
            $usuario = UserDAO::getUserById($id);  // Obtener usuario por ID
    
            if ($usuario) {
                // Devolver solo los datos del usuario (sin la contraseña)
                $user_data = [
                    'id_user' => $usuario->getId_user(),
                    'nombre_user' => $usuario->getNombre_user(),
                    'apellidos_user' => $usuario->getApellidos_user(),
                    'email_user' => $usuario->getEmail_user(),
                    'telefono_user' => $usuario->getTelefono_user(),
                    'direction_user' => $usuario->getDirection_user(),
                    'admin_rol' => $usuario->getAdmin_rol()
                ];
                echo json_encode($user_data);
            } else {
                echo json_encode(['error' => 'Usuario no encontrado']);  // Si no se encuentra el usuario
            }
        } else {
            echo json_encode(['error' => 'ID de usuario no proporcionado']);  // Si no se pasa el ID
        }
    }
    
    // Actualizar un usuario
    public function updateUser() {
        include_once 'models/users/UserDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraer los datos del usuario
            $id = $_POST['id_user'];
            $nombre = $_POST['nombre_user'];
            $apellidos = $_POST['apellidos_user'];
            $email = $_POST['email_user'];
            $telefono = $_POST['telefono_user'];
            $direction = $_POST['direction_user'];
            $rol = $_POST['admin_rol'];
    
            // Verificar si se proporciona una nueva contraseña
            if (empty($_POST['contra_user'])) {
                // Si no se proporciona, usamos la contraseña actual
                $usuario = UserDAO::getUserById($id);
                $contra = $usuario->getPassword_user();
            } else {
                // Si se proporciona, se hashifica
                $contra = password_hash($_POST['contra_user'], PASSWORD_DEFAULT);
            }
    
            // Actualizar los datos del usuario
            $resultado = UserDAO::updateUser($id, $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol);
    
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si es exitoso
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el usuario.']);  // Si falla
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }
    
    // Crear un nuevo usuario
    public function createUser(){
        include_once 'models/users/UserDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si el método es POST
            // Extraer los datos del usuario
            $contra = $_POST['contra_user'];
            $nombre = $_POST['nombre_user'];
            $apellidos = $_POST['apellidos_user'];
            $email = $_POST['email_user'];
            $telefono = $_POST['telefono_user'];
            $direction = $_POST['direction_user'];
            $admin_rol = $_POST['admin_rol'];

            // Hashificar la contraseña
            $contraHash = password_hash($contra, PASSWORD_DEFAULT);

            // Crear el nuevo usuario
            $resultado = UserDAO::createUser($email, $contraHash, $nombre, $apellidos, $telefono, $direction, $admin_rol);
            
            if ($resultado) {
                echo json_encode(['success' => true]);  // Si la creación es exitosa
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el usuario.']);  // Si falla
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);  // Si no es POST
        }
    }

    // Eliminar un usuario
    public function deleteUser() {
        include_once 'models/users/UserDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  // Si el método es DELETE
            // Leer los datos de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['id_user'])) {  // Verificar si se pasa el ID
                $id = $data['id_user'];

                // Eliminar el usuario
                $resultado = UserDAO::deleteUser($id);

                if ($resultado) {
                    echo json_encode(['success' => true]);  // Si la eliminación es exitosa
                } else {
                    http_response_code(500);  // Error interno
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el usuario.']);
                }
            } else {
                http_response_code(400);  // Solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado.']);
            }
        } else {
            http_response_code(405);  // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    // Obtener logs
    public function getLogs(){
        include_once 'models/logs/LogsDAO.php';
        $logs = LogsDAO::getLogs();  // Obtener los logs
        header('Content-Type: application/json');
        echo json_encode($logs);  // Devolver los logs en formato JSON
    }

    public function insertLog() {
    // Incluye el DAO de logs
    include_once 'models/logs/LogsDAO.php';

    // Obtener los datos de la solicitud (asume que es un POST con JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Extraer los valores
    $id_user_log = (int)$data['id_user_log'];
    $action_log = $data['action_log'];
    $apartado_log = $data['apartado_log'];
    $id_apartado_log = (int)$data['id_apartado_log'];

    try {
        // Llamar al método del DAO para insertar el log
        LogsDAO::insertLog($id_user_log, $action_log, $apartado_log, $id_apartado_log);

    } catch (Exception $e) {
        // Manejar errores
        http_response_code(500); // Internal Server Error
        echo json_encode([
            'success' => false,
            'message' => 'Error al insertar el log.',
            'error' => $e->getMessage()
        ]);
    }
    }


}


?>
