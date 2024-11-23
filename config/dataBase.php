<?php
    class DataBase {
        public static function connect($host='localhost', $user='root', $pass='', $db='mammoth',$port='3306'){
            $con = new mysqli($host, $user, $pass, $db, $port);

            if($con === false){
                die("ERROR!¡!¡!¡!: No se puede conectar a la bbdd" . $con ->connect_error);
            } else {
                echo 'conectado';
                return $con;
            }
        }
    }    
?>