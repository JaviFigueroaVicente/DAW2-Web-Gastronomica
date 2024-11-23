<?php
abstract class Pedido{
    protected $id_pedido;
    protected $fecha_pedido;
    protected $estado_pedido;
    protected $id_user_pedido;
    protected $precio_pedido;

    public function __construct($id_pedido,$fecha_pedido,$estado_pedido,$id_user_pedido,$precio_pedido)
    {
        $this -> id_pedido = $id_pedido;
        $this -> fecha_pedido = $fecha_pedido;
        $this -> estado_pedido = $estado_pedido;
        $this -> id_user_pedido = $id_user_pedido;
        $this -> precio_pedido = $precio_pedido;
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
}
?>