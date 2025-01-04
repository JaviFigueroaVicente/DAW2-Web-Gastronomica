<?php
include_once 'models/cesta/Cesta.php';
include_once 'models/cesta/CestaDAO.php';

class CestaController{   
    public function finalizar(){ 
    $cupon = CestaController::agregarCupon();
    $cesta = CestaDAO::getCesta($_SESSION['user_id']);
    $totalCesta = CestaDAO::countTotal($_SESSION['user_id']);        
    include_once "views/finalizar.php";
    }



    public function añadirCesta(){
        $user_id = $_SESSION['user_id'];
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        $tamaño = $_POST['tamaño'];

        $id_oferta = CestaDAO::getOfertaPorProductoYCesta($user_id);

        $cesta = new Cesta();
        $cesta -> setIdUser($user_id);
        $cesta -> setIdProducto($producto_id);
        $cesta -> setCantidad($cantidad);
        $cesta -> setTamaño($tamaño);
        $cesta -> setIdOferta($id_oferta);

        if(CestaDAO::existeProductoCesta($cesta) === false){
            CestaDAO::insertarCesta($cesta);
        }else{
            CestaDAO::actualizarCantidadProductoCesta($cesta);
        }      

        header("Location: ?url=finalizar");
    }

    public function eliminarProductoCesta(){
        $user_id = $_SESSION['user_id'];
        $producto_id = $_POST['producto_id'];

        $cesta = new Cesta();
        $cesta -> setIdUser($user_id);
        $cesta -> setIdProducto($producto_id);

        CestaDAO::eliminarProductoCesta($cesta);

        header("Location: ?url=finalizar");
    }

    public function actualizarCantidadProductoCesta(){
        $user_id = $_SESSION['user_id'];
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];      
        $name = $_POST['modificar'];  
        $tamaño = $_POST['tamaño'];
        
        if($name === 'aumentar'){
            $cantidad++;
            
        }else{
            $cantidad--;            
        }
        
        $cesta = new Cesta();
        $cesta -> setIdUser($user_id);
        $cesta -> setIdProducto($producto_id);
        $cesta -> setCantidad($cantidad);
        $cesta -> setTamaño($tamaño);
        CestaDAO::actualizarCantidadProductoCesta($cesta);

        header("Location: ?url=finalizar");
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