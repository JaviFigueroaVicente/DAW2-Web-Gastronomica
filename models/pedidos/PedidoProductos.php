<?php
include_once "models/pedidos/Pedido.php";
include_once "models/productos/Producto.php";

class PedidoProductos{
    public $id_fila_producto;
    public $id_pedido;
    public $id_producto;
    public $cantidad_producto;
    public $tamaño_producto;
    public $precio_producto;

    public function __construct()
    {
        
    }

    public function getIdFilaProducto()
    {
        return $this->id_fila_producto;
    }
    public function setIdFilaProducto($id_fila_producto)
    {
        $this->id_fila_producto = $id_fila_producto;
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }
    public function setIdPedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    public function getIdProducto()
    {
        return $this->id_producto;
    }
    public function setIdProducto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    public function getCantidadProducto()
    {
        return $this->cantidad_producto;
    }
    public function setCantidadProducto($cantidad_producto)
    {
        $this->cantidad_producto = $cantidad_producto;
    }

    public function getTamañoProducto()
    {
        return $this->tamaño_producto;
    }
    public function setTamañoProducto($tamaño_producto)
    {
        $this->tamaño_producto = $tamaño_producto;
    }

    public function getPrecioProducto()
    {
        return $this->precio_producto;
    }
    public function setPrecioProducto($precio_producto)
    {
        $this->precio_producto = $precio_producto;
    }
}
?>