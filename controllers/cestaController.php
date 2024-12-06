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
}
?>