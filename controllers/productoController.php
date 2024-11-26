<?php
include_once "models/productos/ProductosDAO.php";

class ProductoController{
    public function productos(){
        $productos = ProductosDAO::getAll();
        $total_productos = ProductosDAO::countAll();
        include_once 'views/productos.php';
    }
}
?>
