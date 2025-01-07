<?php
    class DataBase {
        public static function connect($host='fdb1029.awardspace.net', $user='4572359_mammothskitchen', $pass='mammoth2025*', $db='4572359_mammothskitchen',$port='3306'){
            $con = new mysqli($host, $user, $pass, $db, $port);

            if($con === false){
                die("ERROR!¡!¡!¡!: No se puede conectar a la bbdd" . $con ->connect_error);
            } else {
                return $con;
            }
        }
    }    
?>