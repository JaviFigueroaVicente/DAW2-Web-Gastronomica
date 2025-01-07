<?php
include_once "config/dataBase.php";  // Conexión a la base de datos
include_once "models/productos/Productos.php";  // Modelo de la clase Producto

class ProductosDAO {
    
    // Método para obtener todos los productos, con una opción de ordenamiento.
    public static function getAll($orden = null) {
        $con = DataBase::connect();  // Conexión a la base de datos.
    
        // Consulta SQL base para seleccionar todos los productos.
        $sql = "SELECT * FROM productos";
        
        // Agregar condiciones de ordenamiento según el parámetro recibido.
        switch ($orden) {
            case '1': 
                $sql .= " ORDER BY id_producto DESC";  // Ordenar por ID descendente (nuevos primero).
                break;
            case '2': 
                $sql .= " ORDER BY precio_producto DESC";  // Ordenar por precio descendente (más caros).
                break;
            case '3': 
                $sql .= " ORDER BY precio_producto ASC";  // Ordenar por precio ascendente (más baratos).
                break;
            case '4': 
                $sql .= " ORDER BY nombre_producto ASC";  // Ordenar alfabéticamente (A-Z).
                break;
            case '5': 
                $sql .= " ORDER BY nombre_producto DESC";  // Ordenar alfabéticamente (Z-A).
                break;
            default:
                // Si no se pasa ningún parámetro de ordenamiento, se obtiene sin orden específico.
                break;
        }
    
        // Preparar y ejecutar la consulta.
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Arreglo para almacenar los productos obtenidos.
        $productos = [];
        
        // Iterar sobre los resultados y asignarlos al arreglo $productos.
        while ($producto = $result->fetch_object("Productos")) {
            $productos[] = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                // Convertir la foto del producto a formato base64 si existe.
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];
        }
    
        $con->close();  // Cerrar la conexión a la base de datos.
        return $productos;  // Retornar el arreglo de productos.
    }

    // Método para contar el total de productos en la base de datos.
    public static function countAll() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_productos FROM productos");  // Consulta para contar productos.
        $stmt->execute();
        $result = $stmt->get_result();        
        $total = $result->fetch_assoc();  // Obtener el total de productos.
        
        $con->close();
        return $total['total_productos'];  // Retornar el total de productos.
    }

    // Método para obtener un producto individual por su ID.
    public static function getProductoIndividual($id) {
        $con = DataBase::connect();  // Conexión a la base de datos.
        
        if (!$con) {
            error_log("Error de conexión a la base de datos.");  // Log de error si falla la conexión.
            return null;
        }
        
        // Consulta SQL para obtener un producto específico por su ID.
        $stmt = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
        if (!$stmt) {
            error_log("Error al preparar la consulta.");  // Log de error si falla la preparación de la consulta.
            return null;
        }
    
        $stmt->bind_param("i", $id);  // Vincular el parámetro ID.
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Si el producto existe, se obtiene sus detalles.
        if ($result->num_rows > 0) {
            $producto = $result->fetch_object("Productos");
    
            // Log de depuración para mostrar el producto encontrado.
            error_log("Producto encontrado: " . json_encode($producto));
    
            // Retornar los detalles del producto.
            $productoDetalle = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];
    
        } else {
            error_log("No se encontró producto con ID: " . $id);  // Log de error si no se encuentra el producto.
            $productoDetalle = null;  // Si no se encuentra el producto, retornamos null.
        }
    
        $con->close();  // Cerrar la conexión a la base de datos.
        return $productoDetalle;  // Retornar el producto encontrado o null.
    }

    // Método para obtener productos por categoría, con opción de ordenamiento.
    public static function getProductosByCategoria($categoria, $orden = null) {
        $con = DataBase::connect();  // Conexión a la base de datos.
    
        // Consulta base para obtener productos de una categoría específica.
        $sql = "SELECT * FROM productos WHERE id_categoria_producto = ?";
        
        // Agregar condiciones de ordenamiento.
        switch ($orden) {
            case '1': // Nuevos primero.
                $sql .= " ORDER BY id_producto DESC";
                break;
            case '2': // Más caros.
                $sql .= " ORDER BY precio_producto DESC";
                break;
            case '3': // Más baratos.
                $sql .= " ORDER BY precio_producto ASC";
                break;
            case '4': // A-Z.
                $sql .= " ORDER BY nombre_producto ASC";
                break;
            case '5': // Z-A.
                $sql .= " ORDER BY nombre_producto DESC";
                break;
            default:
                // Si no hay orden, no se agrega ninguna condición.
                break;
        }
    
        // Preparar la consulta.
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $categoria);  // Vincular el parámetro de la categoría.
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Arreglo para almacenar los productos obtenidos.
        $productos = [];
        
        // Iterar sobre los productos y agregarlos al arreglo.
        while ($producto = $result->fetch_object("Productos")) {
            $productos[] = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];
        }
    
        $con->close();  // Cerrar la conexión a la base de datos.
        return $productos;  // Retornar los productos encontrados.
    }

    // Método para contar el total de productos en una categoría específica.
    public static function countProductosByCategoria($id_categoria) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_productos FROM productos WHERE id_categoria_producto = ?");
        $stmt->bind_param("i", $id_categoria);  // Vincular el ID de categoría.
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc();  // Obtener el total de productos en la categoría.

        $con->close();
        return $total['total_productos'];  // Retornar el total de productos.
    }

    // Método para buscar productos por nombre (búsqueda de texto).
    public static function getProductosByBusqueda($busqueda) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE nombre_producto LIKE ?");
        $busqueda = '%' . $busqueda . '%';  // Agregar los signos de porcentaje para búsqueda parcial.
        $stmt->bind_param("s", $busqueda);  // Vincular el parámetro de búsqueda.
        $stmt->execute();
        $result = $stmt->get_result();

        // Arreglo para almacenar los productos encontrados.
        $productos = [];
        
        // Iterar sobre los resultados y agregarlos al arreglo.
        while ($producto = $result->fetch_object("Productos")) {
            $productos[] = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];
        }

        $con->close();
        return $productos;  // Retornar los productos encontrados.
    }

    // Método para contar productos por búsqueda (similar al anterior, pero solo retorna el total).
    public static function countProductosByBusqueda($busqueda) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_productos FROM productos WHERE nombre_producto LIKE ?");
        $busqueda = '%' . $busqueda . '%';
        $stmt->bind_param("s", $busqueda);  // Vincular el parámetro de búsqueda.
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc();  // Obtener el total de productos que coinciden con la búsqueda.

        $con->close();
        return $total['total_productos'];  // Retornar el total de productos.
    }

    // Método para actualizar los detalles de un producto.
    public static function updateProducto($id, $nombre, $descripcion, $precio, $stock, $id_categoria_producto, $foto_producto) {
        $con = DataBase::connect();
    
        // Si se proporciona una imagen, la consulta incluye la actualización de la foto.
        if ($foto_producto !== null) {
            $sql = "UPDATE productos SET 
                        nombre_producto = ?, 
                        descripcion_producto = ?, 
                        precio_producto = ?, 
                        stock_producto = ?, 
                        foto_producto = ?,
                        id_categoria_producto = ? 
                    WHERE id_producto = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssdisii", $nombre, $descripcion, $precio, $stock, $foto_producto, $id_categoria_producto, $id);
        } else {
            // Si no se proporciona imagen, solo se actualizan los demás campos.
            $sql = "UPDATE productos SET 
                        nombre_producto = ?, 
                        descripcion_producto = ?, 
                        precio_producto = ?, 
                        stock_producto = ?,
                        id_categoria_producto = ?
                    WHERE id_producto = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $stock, $id_categoria_producto, $id);
        }
    
        $resultado = $stmt->execute();  // Ejecutar la consulta de actualización.
        $stmt->close();
        $con->close();
    
        return $resultado;  // Retornar el resultado de la actualización.
    }

    // Método para eliminar un producto por su ID.
    public static function deleteProducto($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);  // Vincular el parámetro del ID.
        $resultado = $stmt->execute();  // Ejecutar la eliminación.
    
        $stmt->close();
        $con->close();
        return $resultado;  // Retornar el resultado de la eliminación.
    }

    // Método para crear un nuevo producto en la base de datos.
    public static function createProducto($nombre, $descripcion, $precio, $stock, $id_categoria_producto, $foto_producto) {
        $con = DataBase::connect();
    
        // Consulta para insertar un nuevo producto con todos los detalles.
        $sql = "INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, id_categoria_producto, foto_producto) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta.
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssdiis", $nombre, $descripcion, $precio, $stock, $id_categoria_producto, $foto_producto);
    
        $resultado = $stmt->execute();  // Ejecutar la inserción.
    
        $stmt->close();
        $con->close();
    
        return $resultado;  // Retornar el resultado de la creación.
    }
}
?>
