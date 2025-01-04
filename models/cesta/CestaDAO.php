<?php
include_once "config/dataBase.php";
include_once "models/cesta/Cesta.php";
include_once "models/cesta/Cupon.php";

class CestaDAO{  
    public static function getCupon($nombre) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas WHERE nombre_oferta = ?");
        
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($data = $result->fetch_object()) {
            $con->close();
            return [
                "success" => true,
                "message" => "Cupón válido.",
                "discount" => $data->descuento_oferta,
            ];
        }
    
        $con->close();
        return [
            "success" => false,
            "message" => "El cupón no existe.",
        ];
    }
    
    public static function getAllCupones(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas");

        $stmt->execute();
        $result = $stmt->get_result();

        $ofertas = [];
        while($data = $result->fetch_object()){
            $oferta = new Cupon();
            $oferta->setId_oferta($data->id_oferta);
            $oferta->setNombre_oferta($data->nombre_oferta);
            $oferta->setDescripcion_oferta($data->descripcion_oferta);
            $oferta->setDescuento_oferta($data->descuento_oferta);
            $oferta->setFecha_inicio_oferta($data->fecha_inicio_oferta);
            $oferta->setFecha_fin_oferta($data->fecha_fin_oferta);
            
            $ofertas[] = $oferta;
        }

        $con->close();
        return $ofertas;
    }

    public static function updateCupon($cupon, $id_user) {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE cesta SET id__oferta = ? WHERE id__user = ?");
        
        $id_cupon = $cupon->getId_oferta(); 
    
        $stmt->bind_param("ii", $id_cupon, $id_user);
        $stmt->execute();
    
        $con->close();
    
        return true; 
    }
}
?>