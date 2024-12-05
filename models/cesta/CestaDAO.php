<?php
include_once "config/dataBase.php";
include_once "models/cesta/Cesta.php";

class CestaDAO{
    public static function getCesta(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM cesta WHERE id__user = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_object('Cesta')){
            $cesta = $row;
        }
        $con->close();
        return $cesta;
    }
    
    public static function insertarCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO cesta(id__user, id__producto, cantidad, tamaño) VALUES (?,?,?,?)");

        $user_id = $cesta -> getIdUser();
        $producto_id = $cesta -> getIdProducto();
        $cantidad = $cesta -> getCantidad();
        $tamaño = $cesta -> getTamaño();
        
        $stmt->bind_param("iiis", $user_id, $producto_id, $cantidad, $tamaño);

        $stmt->execute();
        $con->close();
        
    }
}
?>