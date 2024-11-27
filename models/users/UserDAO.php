<?php
include_once "config/dataBase.php";
include_once "models/users/User.php";

class UserDAO{
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM USERS");

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while($user = $result->fetch_object("User")){
            $users[] = $user;
        }

        $con->close();
        return $users;
    }

    public static function create($user){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO USERS(email,contra,nombre,apellidos,telefono,direction) VALUES (?,?,?,?,?,?)");

        $email = $user->getEmail_user();
        $contra = $user->getPassword_user();
        $nombre = $user->getNombre_user();
        $apellidos = $user->getApellidos_user();
        $telefono = $user->getTelefono_user();
        $direction= $user->getDirection_user();
        
        $stmt->bind_param("ssssis", $email, $contra, $nombre, $apellidos, $telefono, $direction);

        $stmt->execute();
        $con->close();
    }
}
?>