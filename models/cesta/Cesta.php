<?php
class Cesta{
    public $id_user;
    public $id_producto;
    public $cantidad;
    public $tamaño;

    public function __construct(){
        
    }

    public function getIdUser(){
        return $this->id_user;
    }

    public function getIdProducto(){
        return $this->id_producto;
    }
    public function getCantidad(){
        return $this->cantidad;
    }

    public function setIdUser($id_user){
        $this->id_user = $id_user;
    }

    public function setIdProducto($id_producto){
        $this->id_producto = $id_producto;
    }

    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }

    public function getTamaño(){
        return $this->tamaño;
    }
    public function setTamaño($tamaño){
        $this->tamaño = $tamaño;
    }
}
?>