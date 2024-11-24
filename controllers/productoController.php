<?php
include_once "models/productos/ProductosDAO.php";

class ProductoController{
    public function productos(){
        $productos = ProductosDAO::getAll();
        include_once 'views/productos.php';
    }
}
?>
