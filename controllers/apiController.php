<?php
include_once "config/dataBase.php";

class ApiController {
    public function admin() {
        include_once "views/admin.php";
    }

    // Productos

    public function getProductos() {
        include_once 'models/productos/ProductosDAO.php';
        $productos = ProductosDAO::getAll();
        header('Content-Type: application/json');
        echo json_encode($productos);
    }

    public function getProductoIndividual() {
        include_once 'models/productos/ProductosDAO.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = ProductosDAO::getProductoIndividual($id);
            
            if ($producto) {
                echo json_encode($producto);
            } else {
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID de producto no proporcionado']);
        }
    }
    
    public function updateProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos enviados
            $id = $_POST['id_producto'];
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion_producto'];
            $precio = $_POST['precio_producto'];
            $stock = $_POST['stock_producto'];
    
            // Verificar si se envió una imagen
            $foto_producto = null;
            if (isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {
                $foto_producto = file_get_contents($_FILES['foto_producto']['tmp_name']); // Leer el archivo en binario
            }
    
            // Llamar al modelo para actualizar los datos
            $resultado = ProductosDAO::updateProducto($id, $nombre, $descripcion, $precio, $stock, $foto_producto);
    
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el producto.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    
    
    

    public function deleteProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Leer el cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (isset($data['id_producto'])) {
                $id = $data['id_producto'];
    
                // Eliminar producto en la base de datos
                $resultado = ProductosDAO::deleteProducto($id);
    
                // Responder al cliente
                if ($resultado) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Indicar error interno
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el producto.']);
                }
            } else {
                http_response_code(400); // Solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de producto no proporcionado.']);
            }
        } else {
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    
    public function createProducto() {
        include_once 'models/productos/ProductosDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion_producto'];
            $precio = $_POST['precio_producto'];
            $stock = $_POST['stock_producto'];
            $id_categoria_producto = $_POST['id_categoria_producto'];
            $foto_producto = $_FILES['foto_producto'] ?? null;
    
            $rutaImagen = null;
            if ($foto_producto && $foto_producto['error'] === UPLOAD_ERR_OK) {
                $rutaImagen = file_get_contents($foto_producto['tmp_name']); // Leer contenido binario de la imagen
            }
    
            // Crear producto en la base de datos
            $resultado = ProductosDAO::createProducto($nombre, $descripcion, $precio, $stock, $id_categoria_producto, $rutaImagen);
    
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el producto.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    


    // Pedidos

    public function getPedidos() {
        include_once 'models/pedidos/PedidoDAO.php';
        $pedidos = PedidoDAO::getAllPedidos();
        header('Content-Type: application/json');
        echo json_encode($pedidos);
    }
    public function getPedidoIndividual() {
        include_once 'models/pedidos/PedidoDAO.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pedido = PedidoDAO::getPedidoById($id);

            if ($pedido) {
                echo json_encode($pedido);
            } else {
                echo json_encode(['error' => 'Pedido no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID de pedido no proporcionado']);
        }
    }
    public function updatePedido() {
        include_once 'models/pedidos/PedidoDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos enviados
            $idPedido = $_POST['id_pedido'];
            $fechaPedido = $_POST['fecha_pedido'];
            $estadoPedido = $_POST['estado_pedido'];
            $idUserPedido = $_POST['id_user_pedido'];
            $precioPedido = $_POST['precio_pedido'];
            $direccionPedido = $_POST['direccion_pedido'];
            $metodoPago = $_POST['metodo_pago'];
        
    
            // Llamar al modelo para actualizar los datos
            $resultado = PedidoDAO::updatePedido($idPedido, $fechaPedido, $estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago);
    
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el pedido.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    
    
    public function deletePedido() {
        include_once 'models/pedidos/PedidoDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Leer el cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (isset($data['id_pedido'])) {
                $id = $data['id_pedido'];
    
                // Eliminar producto en la base de datos
                $resultado = PedidoDAO::deletePedido($id);
    
                // Responder al cliente
                if ($resultado) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Indicar error interno
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el pedido.']);
                }
            } else {
                http_response_code(400); // Solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de pedido no proporcionado.']);
            }
        } else {
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    public function createPedido() {
        include_once 'models/pedidos/PedidoDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos
            $estadoPedido = $_POST['estado_pedido'];
            $idUserPedido = $_POST['id_user_pedido'];
            $precioPedido = $_POST['precio_pedido'];
            $direccionPedido = $_POST['direccion_pedido'];
            $metodoPago = $_POST['metodo_pago'];

            $resultado = PedidoDAO::createPedido($estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago);
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el pedido.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    
    // Usuarios

    public function getUsers() {
        include_once 'models/users/UserDAO.php';
        $usuarios = UserDAO::getAllUsers();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    }

    public function getUserIndividual() {
        include_once 'models/users/UserDAO.php';
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $usuario = UserDAO::getUserById($id);
    
            if ($usuario) {
                // Solo devolver los datos del usuario sin la contraseña
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
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
        }
    }
    
    public function updateUser() {
        include_once 'models/users/UserDAO.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos enviados
            $id = $_POST['id_user'];
            $nombre = $_POST['nombre_user'];
            $apellidos = $_POST['apellidos_user'];
            $email = $_POST['email_user'];
            $telefono = $_POST['telefono_user'];
            $direction = $_POST['direction_user'];
            $rol = $_POST['admin_rol'];
    
            // Verificamos si la contraseña fue proporcionada
            if (empty($_POST['contra_user'])) {
                // Si la contraseña no se proporciona, utilizamos la contraseña actual del usuario
                $usuario = UserDAO::getUserById($id);
                $contra = $usuario->getPassword_user();  // Obtiene la contraseña actual
            } else {
                // Si la contraseña se proporciona, la hashamos
                $contra = password_hash($_POST['contra_user'], PASSWORD_DEFAULT);
            }
    
            // Llamar al modelo para actualizar los datos
            $resultado = UserDAO::updateUser($id, $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol);
    
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el usuario.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    
    

    public function createUser(){
        include_once 'models/users/UserDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y extraer datos
            $contra = $_POST['contra_user'];
            $nombre = $_POST['nombre_user'];
            $apellidos = $_POST['apellidos_user'];
            $email = $_POST['email_user'];
            $telefono = $_POST['telefono_user'];
            $direction = $_POST['direction_user'];
            $admin_rol = $_POST['admin_rol'];

            $contraHash = password_hash($contra, PASSWORD_DEFAULT);

            $resultado = UserDAO::createUser($email, $contraHash, $nombre, $apellidos, $telefono, $direction, $admin_rol);
            // Responder al cliente
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo crear el pedido.']);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    public function deleteUser() {
        include_once 'models/users/UserDAO.php';

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Leer el cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['id_user'])) {
                $id = $data['id_user'];

                // Eliminar producto en la base de datos
                $resultado = UserDAO::deleteUser($id);

                // Responder al cliente
                if ($resultado) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Indicar error interno
                    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el usuario.']);
                }
            } else {
                http_response_code(400); // Solicitud incorrecta
                echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado.']);
            }
        } else {
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    public function tramitarPedido() {
        include_once 'models/pedidos/PedidoDAO.php'; // Incluye la clase PedidoDAO para manejar los pedidos.
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Validación básica de datos
            if (!isset($data['id_user'], $data['delivery_option'], $data['pay_option'], $data['products'])) {
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos necesarios para procesar el pedido."
                ]);
                return;
            }
    
            $idUser = $data['id_user'];
            $direccion = $data['delivery_option']; // Se asume que contiene la dirección de entrega o el tipo.
            $metodoPago = $data['pay_option'];
            $idOferta = $data['id_oferta'] ?? null; // Puede ser null si no hay oferta
    
            // Llamar a la función insertarPedido desde PedidoDAO
            try {
                $resultado = PedidoDAO::insertarPedido($idUser, $direccion, $metodoPago, $idOferta);
    
                if ($resultado['success']) {
                    echo json_encode([
                        "success" => true,
                        "id_pedido" => $resultado['id_pedido'],
                        "message" => $resultado['message']
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Error al insertar el pedido."
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => "Ocurrió un error: " . $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Método no permitido."
            ]);
        }
    }
    

    public function login() {
        include_once 'models/users/UserDAO.php';
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!$data || !isset($data['email'], $data['password'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos para iniciar sesión.'
            ]);
            exit;
        }
    
        $email = $data['email'];
        $password = $data['password'];
    
        try {
            $resultado = UserDAO::verifyUser($email, $password);
    
            if ($resultado['success']) {
                echo json_encode([
                    'success' => true,
                    'user' => $resultado['user']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['message']
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al iniciar sesión: ' . $e->getMessage()
            ]);
        }
    }
    
    
}


?>
