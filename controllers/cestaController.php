<?php
include_once 'models/cesta/Cesta.php';
include_once 'models/cesta/CestaDAO.php';

class CestaController{   
    public function finalizar(){ 
    $cupon = CestaController::agregarCupon();    
    include_once "views/finalizar.php";
    }

    public static function agregarCupon(){
        if (!isset($_POST['cupon_nombre']) || empty($_POST['cupon_nombre'])) {  
            return null;
        }
    
        $cupon_nombre = $_POST['cupon_nombre'];
        $cupones = CestaDAO::getAllCupones();

        foreach ($cupones as $cupon) {
            if ($cupon->getNombre_oferta() === $cupon_nombre) {

                $id_user = $_SESSION['user_id']; 
                CestaDAO::updateCupon($cupon, $id_user);
                return $cupon;
            }
        }        
    }

   
}
?>