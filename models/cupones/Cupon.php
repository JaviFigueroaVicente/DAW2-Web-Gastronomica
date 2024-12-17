<?php
class Cupon{
    public $id_oferta;
    public $nombre_oferta;
    public $descripcion_oferta;
    public $descuento_oferta;
    public $fecha_inicio_oferta;
    public $fecha_fin_oferta;

    public function __construct(){
        
    }

    public function getId_oferta()
    {
        return $this->id_oferta;
    }

    public function setId_oferta($id_oferta)
    {
        $this->id_oferta = $id_oferta;

        return $this;
    }
    
    public function getNombre_oferta()
    {
        return $this->nombre_oferta;
    }
    public function setNombre_oferta($nombre_oferta)
    {
        $this->nombre_oferta = $nombre_oferta;

        return $this;
    }
    public function getDescripcion_oferta()
    {
        return $this->descripcion_oferta;
    }
    public function setDescripcion_oferta($descripcion_oferta)
    {
        $this->descripcion_oferta = $descripcion_oferta;

        return $this;
    }
    public function getDescuento_oferta()
    {
        return $this->descuento_oferta;
    }
    public function setDescuento_oferta($descuento_oferta)
    {
        $this->descuento_oferta = $descuento_oferta;

        return $this;
    }

    public function getFecha_inicio_oferta()
    {
        return $this->fecha_inicio_oferta;
    }
    public function setFecha_inicio_oferta($fecha_inicio_oferta)
    {
        $this->fecha_inicio_oferta = $fecha_inicio_oferta;

        return $this;
    }
    public function getFecha_fin_oferta()
    {
        return $this->fecha_fin_oferta;
    }
    public function setFecha_fin_oferta($fecha_fin_oferta)
    {
        $this->fecha_fin_oferta = $fecha_fin_oferta;

        return $this;
    }

}
?>