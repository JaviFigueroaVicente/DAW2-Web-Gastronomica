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
            $productos[] = $producto;
        }

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
}
?>