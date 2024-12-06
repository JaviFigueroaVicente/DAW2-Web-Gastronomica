<?php
include_once "models/cesta/CestaDAO.php";
class FinalizarController{
    public function finalizar(){
        $cesta = CestaDAO::getCesta($_SESSION['user_id']);
        $totalCesta = CestaDAO::countTotal($_SESSION['user_id']);
        include_once "views/finalizar.php";
    }
}
?>