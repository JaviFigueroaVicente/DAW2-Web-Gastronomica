<?php
include_once "models/cesta/CestaDAO.php";
include_once "controllers/CestaController.php";

class FinalizarController{
    public function finalizar(){
        $cupon = CestaController::agregarCupon();
        $cesta = CestaDAO::getCesta($_SESSION['user_id']);
        $totalCesta = CestaDAO::countTotal($_SESSION['user_id']);        
        include_once "views/finalizar.php";
    }
}
?>