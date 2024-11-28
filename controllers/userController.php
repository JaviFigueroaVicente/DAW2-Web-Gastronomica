<?php
include_once "models/users/User.php";
include_once "models/users/UserDAO.php";

class userController{
    public function create(){
        $email = $_POST['email'];
        $contra = $_POST['contra'];
        $nombre = $_POST['nombre'];
        $apellidos = !empty($_POST['apellidos']) ? $_POST['apellidos'] : null;
        $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : null;
        $direction = !empty($_POST['direction']) ? $_POST['direction'] : null;

        $user = new User();
        $user->setEmail_user($email);
        $user->setPassword_user($contra);
        $user->setNombre_user($nombre);
        $user->setApellidos_user($apellidos);
        $user->setTelefono_user($telefono);
        $user->setDirection_user($direction);
        
        UserDAO::create($user);
        header("Location: ?url=login");
    }
    public function entrar(){
        $loginEmail = $_POST['login-email'];
        $loginContra = $_POST['login-contra'];

        $users = UserDAO::getAllUsers();

        // Bucle para verificar si las credenciales coinciden
        foreach ($users as $user) {
            // Compara email y contraseña
            if ($user->getEmail_user() === $loginEmail && password_verify($loginContra, $user->getPassword_user())) {
                // Si se encuentra el usuario, iniciar sesión
                session_start();
                $_SESSION['user_id'] = $user->getId_user();
                $_SESSION['user_name'] = $user->getNombre_user();
                header("Location: ?url=index"); // Redirigir al inicio
                exit;
            }else{
                echo "no se ha detectado usuario";
            }
        }
    }
}   
?>