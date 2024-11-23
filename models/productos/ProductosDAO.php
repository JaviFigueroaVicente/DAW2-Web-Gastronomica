<?php
include_once "config/dataBase.php";
include_once "models/productos/Productos.php";

class ProductosDAO{
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTOS");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while($producto = $result->fetch_object("Producto")){
            $productos[] = $producto;
        }

        $con->close();
        return $productos;
    }
}
?>