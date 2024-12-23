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

    public static function getProductoIndividual($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $producto = $result->fetch_object("Productos");

        $con->close();
        return $producto;
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
}
?>