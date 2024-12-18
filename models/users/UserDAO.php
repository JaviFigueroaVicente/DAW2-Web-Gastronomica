<?php
include_once "config/dataBase.php";
include_once "models/users/User.php";

class UserDAO{
    public static function getAllUsers(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM users");

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($data = $result->fetch_assoc()) {
            $user = new User();
            $user->setId_user($data['id_user']);
            $user->setEmail_user($data['email']);
            $user->setPassword_user($data['contra']);
            $user->setNombre_user($data['nombre']);
            $user->setApellidos_user($data['apellidos'] ?? null);
            $user->setTelefono_user($data['telefono'] ?? null);
            $user->setDirection_user($data['direction'] ?? null);
            $user->setAdmin_rol($data['admin']);

            $users[] = $user; 
        }

        $con->close();
        return $users;
    }

    public static function create($user){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO users(email,contra,nombre,apellidos,telefono,direction) VALUES (?,?,?,?,?,?)");

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

    public static function actualizarPerfil($id, $nombre, $apellidos, $direccion, $telefono) {
        $con = DataBase::connect();

        $stmt = $con->prepare("UPDATE users SET nombre = ?, apellidos = ?, direction = ?, telefono = ? WHERE id_user = ?");
    
        $stmt->bind_param("sssii", $nombre, $apellidos, $direccion, $telefono, $id);
    
        if (is_null($apellidos)) $apellidos = null;
        if (is_null($direccion)) $direccion = null;
        if (is_null($telefono)) $telefono = null;
    
        $resultado = $stmt->execute();
 
        $stmt->close();
        $con->close();
    
        return $resultado;
    }
    
    public static function updateContra($idUsuario, $nuevaContrasena) {
        $con = DataBase::connect();
    
        if (empty($nuevaContrasena)) {
            return false; 
        }

        $stmt = $con->prepare("UPDATE users SET contra = ? WHERE id_user = ?");
        $stmt->bind_param("si", $nuevaContrasena, $idUsuario);
    
        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();
    
        return $resultado;
    }
    
}
?>