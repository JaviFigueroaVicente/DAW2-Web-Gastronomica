<?php
include_once "config/dataBase.php";
include_once "models/users/User.php";

class UserDAO{
    public static function getAllUsers($asArray = false){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM users");

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
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
    

    public static function getUserById($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM users WHERE id_user = ?");

        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();

        $user = null;
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

    public static function updateUser($id, $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol ){
        $con = DataBase::connect();
        
        if($contra === null){
            $stmt = $con->prepare("UPDATE users SET nombre = ?, apellidos = ?, email = ?, telefono = ?, direction = ?, admin = ? WHERE id_user = ?");
            $stmt->bind_param("sssisii", $nombre, $apellidos, $email, $telefono, $direction, $rol, $id);
        }else{
            $stmt = $con->prepare("UPDATE users SET contra = ?, nombre = ?, apellidos = ?, email = ?, telefono = ?, direction = ?, admin = ? WHERE id_user = ?");
            $stmt->bind_param("ssssssii", $contra, $nombre, $apellidos, $email, $telefono, $direction, $rol, $id);
        }
        
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function createUser($email, $contra, $nombre, $apellidos, $telefono, $direction, $rol){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO users(email, contra, nombre, apellidos, telefono, direction, admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisi", $email, $contra, $nombre, $apellidos, $telefono, $direction, $rol);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function deleteUser($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function verifyUser($email, $password) {
        $con = DataBase::connect();
    
        $sql = "SELECT id_user, nombre, contra FROM users WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
    
            // Verifica la contraseña con hash
            if (password_verify($password, $user['contra'])) {
                return [
                    'success' => true,
                    'user' => [
                        'id_user' => $user['id_user'],
                        'nombre' => $user['nombre'],
                        'admin_rol' => $user['admin']
                    ],
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Credenciales incorrectas.',
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Credenciales incorrectas.',
            ];
        }
    
        $stmt->close();
        $con->close();
    }
    
    
}
?>