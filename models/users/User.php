<?php
    class User{
        protected $id_user;
        protected $nombre_user;
        protected $apellidos_user;
        protected $password_user;        
        protected $direction_user;
        protected $telefono_user;
        protected $email_user;
        

        public function __construct()
        {
        
        }

        
        public function getId_user()
        {
                return $this->id_user;
        }

        public function setId_user($id_user)
        {
                $this->id_user = $id_user;

                return $this;
        }

        
        public function getNombre_user()
        {
                return $this->nombre_user;
        }

        public function setNombre_user($nombre_user)
        {
                $this->nombre_user = $nombre_user;

                return $this;
        }

     
        public function getApellidos_user()
        {
                return $this->apellidos_user;
        }

        public function setApellidos_user($apellidos_user)
        {
                $this->apellidos_user = $apellidos_user;

                return $this;
        }

       
        public function getPassword_user()
        {
                return $this->password_user;
        }

        public function setPassword_user($password_user)
        {
                $this->password_user = $password_user;

                return $this;
        }

       
        public function getDirection_user()
        {
                return $this->direction_user;
        }
 
        public function setDirection_user($direction_user)
        {
                $this->direction_user = $direction_user;

                return $this;
        }

      
        public function getTelefono_user()
        {
                return $this->telefono_user;
        }

        public function setTelefono_user($telefono_user)
        {
                $this->telefono_user = $telefono_user;

                return $this;
        }

       
        public function getEmail_user()
        {
                return $this->email_user;
        }

        public function setEmail_user($email_user)
        {
                $this->email_user = $email_user;

                return $this;
        }

    }
?>  