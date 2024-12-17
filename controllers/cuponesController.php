<?php
include_once "models/cupones/Cupon.php";
include_once "models/cupones/CuponDAO.php";

class CuponesController{
    public function agregarCupon(){
        $cupon_nombre = $_POST['cupon_nombre'];

        $cupones = CuponDAO::getAllCupones();
        foreach($cupones as $cupon){
            if($cupon->getNombre_oferta() === $cupon_nombre){
                echo "Cupon válido";
            }else{
                echo "cupon no valido";
            }
        }
    }
}
?>