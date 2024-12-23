<?php
include_once "models/categorias/CategoriaProducto.php";
    class Productos extends CategoriaProducto {
        public $id_producto;
        public $nombre_producto;
        public $descripcion_producto;
        public $precio_producto;
        public $stock_producto;
        public $foto_producto;


        public function __construct()
        {
               parent::__construct(); 
        }
        public function getId_producto()
        {
                return $this->id_producto;
        }
        public function setId_producto($id_producto)
        {
                $this->id_producto = $id_producto;

                return $this;
        }

       
        public function getNombre_producto()
        {
                return $this->nombre_producto;
        }

        public function setNombre_producto($nombre_producto)
        {
                $this->nombre_producto = $nombre_producto;

                return $this;
        }

       
        public function getDescripcion_producto()
        {
                return $this->descripcion_producto;
        }

        public function setDescripcion_producto($descripcion_producto)
        {
                $this->descripcion_producto = $descripcion_producto;

                return $this;
        }

       
        public function getPrecio_producto()
        {
                return $this->precio_producto;
        }

        public function setPrecio_producto($precio_producto)
        {
                $this->precio_producto = $precio_producto;

                return $this;
        }

        
        public function getStock_producto()
        {
                return $this->stock_producto;
        }

        public function setStock_producto($stock_producto)
        {
                $this->stock_producto = $stock_producto;

                return $this;
        }

       
        public function getFoto_producto()
        {
                return $this->foto_producto;
        }

        public function setFoto_producto($foto_producto)
        {
                $this->foto_producto = $foto_producto;

                return $this;
        }
    }
?>