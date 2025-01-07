<?php
// Incluir los archivos necesarios para la conexión a la base de datos y el modelo de Logs
include_once 'config/dataBase.php';
include_once 'models/logs/Logs.php';

class LogsDAO {

    // Método para obtener todos los logs desde la base de datos
    public static function getLogs(){
        // Establecer la conexión con la base de datos
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para obtener todos los logs
        $stmt = $con->prepare("SELECT * FROM logs");
        $stmt->execute();
        $result = $stmt->get_result();

        // Crear un array vacío para almacenar los logs
        $logs =[];

        // Recorrer cada registro de log y almacenarlos en el array
        while ($log = $result->fetch_object("Logs")){
            $logs[] = [
                'id_log' => $log->getIdLog(),
                'id_user_log' => $log->getIdUserLog(),
                'action_log' => $log->getActionLog(),
                'apartado_log' => $log->getApartadoLog(),
                'id_apartado_log' => $log->getIdApartadoLog(),
                'fecha_log' => $log->getFechaLog()
            ];
        }

        // Cerrar la conexión a la base de datos
        $con->close();

        // Devolver el array con los logs obtenidos
        return $logs;
    }

    // Método para insertar un nuevo log en la base de datos
    public static function insertLog($id_user_log, $action_log, $apartado_log, $id_apartado_log){
        // Establecer la conexión con la base de datos
        $con = DataBase::connect();
        
        // Preparar la consulta SQL para insertar el log en la base de datos
        $stmt = $con->prepare("INSERT INTO logs (id_user_log, action_log, apartado_log, id_apartado_log, fecha_log) VALUES (?, ?, ?, ?, NOW())");

        // Comprobar si la preparación de la consulta ha fallado
        if (!$stmt) {
            // Manejo de errores si la preparación de la consulta falla
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta SQL.']);
            return;
        }
        
        // Enlazar los parámetros de la consulta SQL
        $stmt->bind_param("issi", $id_user_log, $action_log, $apartado_log, $id_apartado_log);

        // Ejecutar la consulta
        $stmt->execute();

        // Comprobar si hubo errores durante la ejecución de la consulta
        if ($stmt->error) {
            // Manejo de errores si la ejecución falla
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta SQL: ' . $stmt->error]);
            return;
        }

        // Cerrar la conexión a la base de datos
        $con->close();
    }
}
?>
