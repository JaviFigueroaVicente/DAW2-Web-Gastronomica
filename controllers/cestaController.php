<?php
include_once 'models/cesta/Cesta.php';
include_once 'models/cesta/CestaDAO.php';

class CestaController{
    public function añadirCesta(){
        $user_id = $_SESSION['user_id'];
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        $tamaño = $_POST['tamaño'];

        $cesta = new Cesta();
        $cesta -> setIdUser($user_id);
        $cesta -> setIdProducto($producto_id);
        $cesta -> setCantidad($cantidad);
        $cesta -> setTamaño($tamaño);

        CestaDAO::insertarCesta($cesta);

        header("Location: ?url=finalizar");
    }
}
?>