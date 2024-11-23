<?php
include_once "models/productos/Productos.php";
include_once "models/productos/ProductosDAO.php";

class productoController{
    public function index(){
        $productos = ProductosDAO::getAll();
        include_once 'views/index.php';
    }
}
?>
