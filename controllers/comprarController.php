<?php
include_once "models/cesta/CestaDAO.php";

class ComprarController{
    public function comprar(){
        $cesta = CestaDAO::getCesta($_SESSION['user_id']);
        include_once "views/comprar.php";
    }    
}
?>