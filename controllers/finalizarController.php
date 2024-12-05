<?php
class FinalizarController{
    public function finalizar(){
        $cesta = CestaDAO::getCesta();
        include_once "views/finalizar.php";
    }
}
?>