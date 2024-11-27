<?php
include_once "models/users/User.php";
include_once "models/users/UserDAO.php";

class userController{
    public function create(){
        $email = $_POST['email'];
        $contra = $_POST['contra'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $direction = $_POST['direction'];

        $user = new User();
        $user->setEmail_user($email);
        $user->setPassword_user($contra);
        $user->setNombre_user($nombre);
        $user->setApellidos_user($apellidos);
        $user->setTelefono_user($telefono);
        $user->setDirection_user($direction);
        
        UserDAO::create($user);
        header('Location:?url=login');
    }
}
?>