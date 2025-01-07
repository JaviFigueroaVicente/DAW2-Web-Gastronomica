<?php
include_once "config/dataBase.php";
include_once "models/users/User.php";

class UserDAO {
    // Obtener todos los usuarios desde la base de datos
    public static function getAllUsers($asArray = false) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM users");

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        // Recorrer y almacenar usuarios en array o como objetos User
        while ($data = $result->fetch_assoc()) {
            if ($asArray) {
                $users[] = [
                    'id_user' => $data['id_user'],
                    'email' => $data['email'],
                    'contra' => $data['contra'],
                    'nombre' => $data['nombre'],
                    'apellidos' => $data['apellidos'] ?? null,
                    'telefono' => $data['telefono'] ?? null,
                    'direction' => $data['direction'] ?? null,
                    'admin' => $data['admin'],
                ];
            } else {
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
        }

        $con->close();
        return $users;
    }

    // Crear un nuevo usuario en la base de datos
    public static function create($user) {
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO users(email, contra, nombre, apellidos, telefono, direction) VALUES (?,?,?,?,?,?)");

        $email = $user->getEmail_user();
        $contra = $user->getPassword_user();
        $nombre = $user->getNombre_user();
        $apellidos = $user->getApellidos_user();
        $telefono = $user->getTelefono_user();
        $direction = $user->getDirection_user();

        $stmt->bind_param("ssssis", $email, $contra, $nombre, $apellidos, $telefono, $direction);

        $stmt->execute();
        $con->close();
    }

    public static function emailExists($email) {
        // Conectar a la base de datos
        $con = DataBase::connect();
    
        // Prepara la consulta SQL para verificar si el correo electrónico ya existe
        $stmt = $con->prepare("SELECT id_user FROM users WHERE email = ?");
        
        if (!$stmt) {
            // Si hay un error en la preparación de la consulta, mostramos el error y retornamos falso
            error_log("Error en la preparación de la consulta: " . $con->error);
            return false;
        }
    
        // Vincula el parámetro email a la consulta
        $stmt->bind_param("s", $email);
    
        // Ejecuta la consulta
        $stmt->execute();
    
        // Verifica si se ha encontrado un resultado
        $result = $stmt->get_result();
    
        // Si el resultado tiene al menos una fila, el correo ya existe
        $exists = $result->num_rows > 0;
    
        // Cierra la conexión
        $stmt->close();
        $con->close();
    
        // Retorna verdadero si el correo existe, falso en caso contrario
        return $exists;
    }
    // Actualizar perfil de un usuario
    public static function actualizarPerfil($id, $nombre, $apellidos, $direccion, $telefono) {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE users SET nombre = ?, apellidos = ?, direction = ?, telefono = ? WHERE id_user = ?");

        $stmt->bind_param("sssii", $nombre, $apellidos, $direccion, $telefono, $id);

        // Ajustes de null para algunos campos
        if (is_null($apellidos)) $apellidos = null;
        if (is_null($direccion)) $direccion = null;
        if (is_null($telefono)) $telefono = 0;

        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();

        return $resultado;
    }

    // Actualizar contraseña de un usuario
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

    // Obtener un usuario por su ID
    public static function getUserById($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM users WHERE id_user = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = null;
        // Si existe, crear el objeto User
        if ($data = $result->fetch_assoc()) {
            $user = new User();
            $user->setId_user($data['id_user']);
            $user->setPassword_user($data['contra']);
            $user->setEmail_user($data['email']);
            $user->setNombre_user($data['nombre']);
            $user->setApellidos_user($data['apellidos'] ?? null);
            $user->setTelefono_user($data['telefono'] ?? 0);
            $user->setDirection_user($data['direction'] ?? null);
            $user->setAdmin_rol($data['admin']);
        }

        $con->close();
        return $user;
    }

    // Actualizar los datos de un usuario (incluyendo la contraseña opcional)
    public static function updateUser($id, $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol) {
        $con = DataBase::connect();

        // Si no se incluye contraseña, solo se actualizan otros datos
        if ($contra === null) {
            $stmt = $con->prepare("UPDATE users SET nombre = ?, apellidos = ?, email = ?, telefono = ?, direction = ?, admin = ? WHERE id_user = ?");
            $stmt->bind_param("sssisii", $nombre, $apellidos, $email, $telefono, $direction, $rol, $id);
        } else {
            // Si se incluye contraseña, también se actualiza
            $stmt = $con->prepare("UPDATE users SET contra = ?, nombre = ?, apellidos = ?, email = ?, telefono = ?, direction = ?, admin = ? WHERE id_user = ?");
            $stmt->bind_param("ssssssii", $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol, $id);
        }

        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    // Crear un usuario con rol y demás detalles
    public static function createUser($email, $contra, $nombre, $apellidos, $telefono, $direction, $rol) {
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO users(email, contra, nombre, apellidos, telefono, direction, admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisi", $email, $contra, $nombre, $apellidos, $telefono, $direction, $rol);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    // Eliminar un usuario de la base de datos
    public static function deleteUser($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }
}
?>
