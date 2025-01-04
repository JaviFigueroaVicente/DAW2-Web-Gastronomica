<?php
include_once 'config/dataBase.php';
include_once 'models/logs/Logs.php';

class LogsDAO{
    public static function getLogs(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM logs");
        $stmt->execute();
        $result = $stmt->get_result();

        $logs =[];

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
        $con->close();
        return $logs;
    }

    public static function insertLog($id_user_log, $action_log, $apartado_log, $id_apartado_log){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO logs (id_user_log, action_log, apartado_log, id_apartado_log, fecha_log) VALUES (?, ?, ?, ?, NOW())");
        
        if (!$stmt) {
            // Manejo de errores si la preparación de la consulta falla
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta SQL.']);
            return;
        }
    
        $stmt->bind_param("issi", $id_user_log, $action_log, $apartado_log, $id_apartado_log);
        $stmt->execute();
    
        if ($stmt->error) {
            // Manejo de errores si la ejecución falla
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta SQL: ' . $stmt->error]);
            return;
        }
    
        $con->close();
    }
    
}
?>