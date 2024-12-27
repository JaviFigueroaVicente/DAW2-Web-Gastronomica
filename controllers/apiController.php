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
            $pedido = PedidoDAO::getPedidoIndividual($id);

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
            $id = $_POST['id_pedido'];
            $id_usuario = $_POST['id_usuario'];
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $fecha_pedido = $_POST['fecha_pedido'];
            $estado_pedido = $_POST['estado_pedido'];

            // Llamar al modelo para actualizar los datos
            $resultado = PedidoDAO::updatePedido($id, $id_usuario, $id_producto, $cantidad, $fecha_pedido, $estado_pedido);

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

                // Eliminar pedido en la base de datos
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
            $id_usuario = $_POST['id_usuario'];
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $fecha_pedido = $_POST['fecha_pedido'];
            $estado_pedido = $_POST['estado_pedido'];

            // Crear pedido en la base de datos
            $resultado = PedidoDAO::createPedido($id_usuario, $id_producto, $cantidad, $fecha_pedido, $estado_pedido);

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

    
}


?>
