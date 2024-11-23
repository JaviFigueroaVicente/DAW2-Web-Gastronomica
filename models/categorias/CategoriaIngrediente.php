<?php
    abstract class CategoriaIngrediente{
        protected $id_categoria_ingrediente;
        protected $nombre_categoria_ingrediente;

        public function __construct($id_categoria_ingrediente,$nombre_categoria_ingrediente){
            $this -> id_categoria_ingrediente = $id_categoria_ingrediente;
            $this -> nombre_categoria_ingrediente = $nombre_categoria_ingrediente;
        }

        public function getId_categoria_ingrediente()
        {
                return $this->id_categoria_ingrediente;
        }

        public function setId_categoria_ingrediente($id_categoria_ingrediente)
        {
                $this->id_categoria_ingrediente = $id_categoria_ingrediente;

                return $this;
        }

       
        public function getNombre_categoria_ingrediente()
        {
                return $this->nombre_categoria_ingrediente;
        }

        public function setNombre_categoria_ingrediente($nombre_categoria_ingrediente)
        {
                $this->nombre_categoria_ingrediente = $nombre_categoria_ingrediente;

                return $this;
        }
    }
?>