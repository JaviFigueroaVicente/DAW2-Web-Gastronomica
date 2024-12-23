<?php
    class CategoriaProducto{
        public $id_categoria_producto;
        public $nombre_categoria_producto;

        public function __construct(){

        }
      
        public function getId_categoria_producto()
        {
                return $this->id_categoria_producto;
        }

        public function setId_categoria_producto($id_categoria_producto)
        {
                $this->id_categoria_producto = $id_categoria_producto;

                return $this;
        }

       
        public function getNombre_categoria_producto()
        {
                return $this->nombre_categoria_producto;
        }

        public function setNombre_categoria_producto($nombre_categoria_producto)
        {
                $this->nombre_categoria_producto = $nombre_categoria_producto;

                return $this;
        }
    }
?>