<?php
include_once "models/productos/ProductosDAO.php";

class ProductoIndividualController{
    public function productoIndividual(){
        $id = intval($_GET['id']);
        $productoIndividual = ProductosDAO::getProductoIndividual($id);
        include_once 'views/producto-individual.php';        
    }
}
?>
