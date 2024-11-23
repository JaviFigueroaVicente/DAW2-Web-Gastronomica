<?php
    require_once "models/ingredientes/Ingredientes.php";

    abstract class Ingredientes extends CategoriaIngrediente{
        protected $id_ingrediente;
        protected $nombre_ingrediente;
        protected $precio_ingrediente;
        protected $stock_ingrediente;
        protected $foto_ingrediente;
        
        public function __construct($id_ingrediente,$nombre_ingrediente,$precio_ingrediente,$stock_ingrediente, $foto_ingrediente, $id_categoria)
        {
            parent::__construct($id_categoria);
            $this -> id_ingrediente = $id_ingrediente;
            $this -> nombre_ingrediente = $nombre_ingrediente;
            $this -> precio_ingrediente = $precio_ingrediente;
            $this -> stock_ingrediente = $stock_ingrediente;
            $this -> foto_ingrediente = $foto_ingrediente;
        }

        public function getId_ingrediente()
        {
                return $this->id_ingrediente;
        }

        public function setId_ingrediente($id_ingrediente)
        {
                $this->id_ingrediente = $id_ingrediente;

                return $this;
        }

    
        public function getNombre_ingrediente()
        {
                return $this->nombre_ingrediente;
        }

        public function setNombre_ingrediente($nombre_ingrediente)
        {
                $this->nombre_ingrediente = $nombre_ingrediente;

                return $this;
        }

         
        public function getPrecio_ingrediente()
        {
                return $this->precio_ingrediente;
        }

        public function setPrecio_ingrediente($precio_ingrediente)
        {
                $this->precio_ingrediente = $precio_ingrediente;

                return $this;
        }


        public function getStock_ingrediente()
        {
                return $this->stock_ingrediente;
        }

        public function setStock_ingrediente($stock_ingrediente)
        {
                $this->stock_ingrediente = $stock_ingrediente;

                return $this;
        }

       
        public function getFoto_ingrediente()
        {
                return $this->foto_ingrediente;
        }

        public function setFoto_ingrediente($foto_ingrediente)
        {
                $this->foto_ingrediente = $foto_ingrediente;

                return $this;
        }
    }
?>  