<?php
include_once "config/dataBase.php";
include_once "models/productos/Productos.php";

class ProductosDAO{
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while($producto = $result->fetch_object("Productos")){
            $productos[] = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];}

        $con->close();
        return $productos;
    }

    public static function countAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_productos FROM productos");

        $stmt->execute();
        $result = $stmt->get_result();        
        $total = $result->fetch_assoc();
        
        $con->close();
        return $total['total_productos'];
    }

    public static function getProductoIndividual($id) {
        $con = DataBase::connect();
        
        if (!$con) {
            error_log("Error de conexión a la base de datos.");
            return null;
        }
        
        $stmt = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
        if (!$stmt) {
            error_log("Error al preparar la consulta.");
            return null;
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $producto = $result->fetch_object("Productos");
    
            // Registra el producto encontrado en formato JSON para debugging
            error_log("Producto encontrado: " . json_encode($producto));
    
            // Retorna los datos del producto de la misma manera que en la función getAll()
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
            error_log("No se encontró producto con ID: " . $id);
            $productoDetalle = null;  // Si no se encuentra el producto, retornamos null
        }
    
        $con->close();
        return $productoDetalle;
    }
    
    
    
    

    public static function getProductosByCategoria($id_categoria){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id_categoria_producto = ?");

        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while($producto = $result->fetch_object("Productos")){
            $productos[] = [
                'id_producto' => $producto->getId_producto(),
                'nombre_producto' => $producto->getNombre_producto(),
                'descripcion_producto' => $producto->getDescripcion_producto(),
                'precio_producto' => $producto->getPrecio_producto(),
                'stock_producto' => $producto->getStock_producto(),
                'foto_producto' => $producto->getFoto_producto() ? 'data:image/webp;base64,' . base64_encode($producto->getFoto_producto()) : null,
                'id_categoria_producto' => $producto->getId_categoria_producto()
            ];}

        $con->close();
        return $productos;
    }

    public static function countProductosByCategoria($id_categoria){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_productos FROM productos WHERE id_categoria_producto = ?");

        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc();

        $con->close();
        return $total['total_productos'];
    }


    public static function getProductosByOferta($id_oferta){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id_oferta_producto = ?");
        $stmt->bind_param("i", $id_oferta);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = [];
    }

    public static function getProductosOrdenados(){

    }

    public static function updateProducto($id, $nombre, $descripcion, $precio, $stock) {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE productos SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, stock_producto = ? WHERE id_producto = ?");
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function deleteProducto($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();
        return $resultado;
    }
    
    
}
?>