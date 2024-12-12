<?php
class Pedido{
    public $id_pedido;
    public $fecha_pedido;
    public $estado_pedido;
    public $id_user_pedido;
    public $precio_pedido;
    public $direccion_pedido;
    public $metodo_pago_pedido;

    public function __construct()
    {
        
    }

   
    public function getId_pedido()
    {
        return $this->id_pedido;
    }

    public function setId_pedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;

        return $this;
    }

   
    public function getFecha_pedido()
    {
        return $this->fecha_pedido;
    }

    public function setFecha_pedido($fecha_pedido)
    {
        $this->fecha_pedido = $fecha_pedido;

        return $this;
    }

    
    public function getEstado_pedido()
    {
        return $this->estado_pedido;
    }

    public function setEstado_pedido($estado_pedido)
    {
        $this->estado_pedido = $estado_pedido;

        return $this;
    }

  
    public function getId_user_pedido()
    {
        return $this->id_user_pedido;
    }

    public function setId_user_pedido($id_user_pedido)
    {
        $this->id_user_pedido = $id_user_pedido;

        return $this;
    }

   
    public function getPrecio_pedido()
    {
        return $this->precio_pedido;
    }

    public function setPrecio_pedido($precio_pedido)
    {
        $this->precio_pedido = $precio_pedido;

        return $this;
    }

    public function getDireccion_pedido()
    {
        return $this->direccion_pedido;
    }
    public function setDireccion_pedido($direccion_pedido)
    {
        $this->direccion_pedido = $direccion_pedido;

        return $this;
    }
}
?>