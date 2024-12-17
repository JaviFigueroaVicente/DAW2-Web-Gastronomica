<?php
include_once "config/dataBase.php";
include_once "models/cupones/Cupon.php";

class CuponDAO{
    public static function getAllCupones(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas");

        $stmt->execute();
        $result = $stmt->get_result();

        $ofertas = [];
        while($data = $result->fetch_object()){
            $oferta = new Cupon();
            $oferta->setId_oferta($data['id_oferta']);
            $oferta->setNombre_oferta($data['nombre_oferta']);
            $oferta->setDescripcion_oferta($data['descripcion_oferta']);
            $oferta->setDescuento_oferta($data['descuento_oferta']);
            $oferta->setFecha_inicio_oferta($data['fecha_inicio_oferta']);
            $oferta->setFecha_fin_oferta($data['fecha_fin_oferta']);
            
            $ofertas[] = $oferta;
        }

        $con->close();
        return $ofertas;
    }
}

?>