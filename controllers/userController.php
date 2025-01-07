<?php
// Incluir los modelos necesarios para interactuar con la base de datos de usuarios
include_once "models/users/User.php";
include_once "models/users/UserDAO.php";

class UserController {

    // Muestra la vista de login
    public function login() {
        include_once "views/login.php";
    }

    // Muestra la vista de registro
    public function registro() {
        include_once "views/registro.php";
    }

    // Muestra la vista de datos de acceso del perfil
    public function datosAcceso() {
        include_once 'views/perfil/datos-acceso.php';
    }

    // Muestra la vista para cambiar la contraseña
    public function cambiarContra() {
        include_once 'views/perfil/datos-cambiar-contra.php';
    }

    // Muestra la vista de la cuenta
    public function cuenta() {
        include_once "views/cuenta.php";
    }

    // Muestra los datos personales del usuario
    public function datosPersonales() {
        include_once "views/perfil/datos-personales.php";
    }

    // Crea un nuevo usuario en la base de datos
    public function create() {
        // Inicializa un array para almacenar los errores
        $errors = [];
    
        // Recoge los datos del formulario
        $email = $_POST['email'];
        $contra = $_POST['contra'];
        $nombre = $_POST['nombre'];
        $apellidos = !empty($_POST['apellidos']) ? $_POST['apellidos'] : null;
        $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : 0;
        $direction = !empty($_POST['direction']) ? $_POST['direction'] : null;
    
        // Validar los datos
        // Validación de email
        if (empty($email)) {
            $errors[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }
    
        // Validación de contraseña
        if (empty($contra)) {
            $errors[] = "La contraseña es obligatoria.";
        } elseif (strlen($contra) < 8) {
            $errors[] = "La contraseña debe tener al menos 8 caracteres.";
        }
    
        // Validación de nombre
        if (empty($nombre)) {
            $errors[] = "El nombre es obligatorio.";
        }
    
        // Si hay errores, redirige al formulario con los errores
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST; // Guarda los datos del formulario para que no se pierdan al volver
            header("Location: ?url=registro");
            exit(); // Asegúrate de terminar la ejecución aquí para evitar seguir con el código
        }
    
        // Si todo está bien, procesa los datos
        $contraHashed = password_hash($contra, PASSWORD_DEFAULT);
    
        $user = new User();
        $user->setEmail_user($email);
        $user->setPassword_user($contraHashed);
        $user->setNombre_user($nombre);
        $user->setApellidos_user($apellidos);
        $user->setTelefono_user($telefono);
        $user->setDirection_user($direction);
    
        // Verifica si el email ya está registrado
        if (UserDAO::emailExists($email)) {
            $_SESSION['errors'] = ["El correo electrónico ya está registrado."];
            $_SESSION['form_data'] = $_POST; // Guarda los datos del formulario
            header("Location: ?url=registro");
            exit();
        }
    
        // Inserta el usuario en la base de datos
        UserDAO::create($user);
    
        // Redirige al usuario a la página de login
        header("Location: ?url=login");
    }
    
    // Valida el login del usuario
    public function entrar() {
        $error = ""; 
        
        // Verifica si los campos de login no están vacíos
        if (empty($_POST['login-email']) || empty($_POST['login-contra'])) {
            $error = "Por favor completa todos los campos.";
            include_once "views/login.php";
            return;
        }

        // Recupera los datos del formulario de login y verifica las credenciales
        $loginEmail = $_POST['login-email'];
        $loginContra = $_POST['login-contra'];    
        $users = UserDAO::getAllUsers();
        foreach ($users as $user) {
            if ($user->getEmail_user() === $loginEmail) {   
                if (password_verify($loginContra, $user->getPassword_user())) {
                    session_start();
                    $_SESSION['user_id'] = $user->getId_user();
                    $_SESSION['user_name'] = $user->getNombre_user();
                    $_SESSION['user_email'] = $user->getEmail_user();
                    $_SESSION['user_apellidos'] = $user->getApellidos_user();
                    $_SESSION['user_direction'] = $user->getDirection_user();
                    $_SESSION['user_telefono'] = $user->getTelefono_user();
                    $_SESSION['user_rol'] = $user->getAdmin_rol();
                    header("Location: ?url=index");
                    exit;
                } else {
                    $error = "La contraseña no es correcta.";
                    include 'views/login.php'; 
                    return;
                }
            }
        }
        $error = "El email no está registrado.";
        include 'views/login.php'; 
    }

    // Cierra sesión del usuario
    public function logout() {
        session_start();
        session_destroy();
        header("Location: ?url=login");
        exit;
    }

    // Actualiza el perfil del usuario
    public function actualizarPerfil() {
        $id = $_SESSION['user_id']; 
        $nombre = $_POST['nombre-actualizar'];
        $apellidos = !empty($_POST['apellidos-actualizar']) ? $_POST['apellidos-actualizar'] : null;
        $direccion = !empty($_POST['direction-actualizar']) ? $_POST['direction-actualizar'] : null;
        $telefono = !empty($_POST['telefono-actualizar']) ? $_POST['telefono-actualizar'] : null;
        
        // Llama a la función de DAO para actualizar los datos en la base de datos
        $resultado = UserDAO::actualizarPerfil($id, $nombre, $apellidos, $direccion, $telefono);
        
        if ($resultado) {
            // Actualiza la sesión con los nuevos datos
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_apellidos'] = $apellidos;
            $_SESSION['user_direction'] = $direccion;
            $_SESSION['user_telefono'] = $telefono;
            header("Location: ?url=datos-personales");
            exit;
        } else {
            echo "Hubo un error al actualizar el perfil. Inténtalo de nuevo.";
        }
    }

    // Actualiza la contraseña del usuario
    public function updateContra() {
        if (empty($_POST['actu-contra']) || empty($_POST['confirm-contra'])) {
            echo "Por favor completa todos los campos.";
            return;
        }

        // Verifica que la nueva contraseña sea válida
        $nuevaContrasena = $_POST['actu-contra'];
        $confirmContrasena = $_POST['confirm-contra'];
        $contraHashed = password_hash($confirmContrasena, PASSWORD_DEFAULT);
        
        if (strlen($nuevaContrasena) < 8) {
            echo "La contraseña debe tener al menos 8 caracteres.";
            return;
        }

        if ($nuevaContrasena !== $confirmContrasena) {
            echo "Las contraseñas no coinciden.";
            return;
        }

        // Actualiza la contraseña en la base de datos
        session_start();
        $idUsuario = $_SESSION['user_id'];
        $resultado = UserDAO::updateContra($idUsuario, $contraHashed);
    
        if ($resultado) {
            echo "Contraseña actualizada correctamente.";
            header("Location: ?url=datos-acceso");
            exit;
        } else {
            echo "Hubo un error al actualizar la contraseña. Inténtalo de nuevo.";
        }
    }      
}   
?>
