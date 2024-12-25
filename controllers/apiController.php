<?php
include_once "config/dataBase.php";

class ApiController {
    public function admin() {
        include_once "views/admin.php";
    }

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
    
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Leer el cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
    
            // Validar y extraer datos
            $id = $data['id_producto'];
            $nombre = $data['nombre_producto'];
            $descripcion = $data['descripcion_producto'];
            $precio = $data['precio_producto'];
            $stock = $data['stock_producto'];
    
            // Actualizar producto en la base de datos
            $resultado = ProductosDAO::updateProducto($id, $nombre, $descripcion, $precio, $stock);
    
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
    
}


?>
