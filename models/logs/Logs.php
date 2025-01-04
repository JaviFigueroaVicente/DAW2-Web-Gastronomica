<?php
class Logs{
    public $id_log;
    public $id_user_log;
    public $action_log;
    public $apartado_log;
    public $id_apartado_log;
    public $fecha_log;

    public function __construct()
    {
        
    }

    public function setIdLog($id_log){
        $this->id_log = $id_log;
    }
    public function getIdLog(){
        return $this->id_log;
    }
    public function setIdUserLog($id_user_log){
        $this->id_user_log = $id_user_log;
    }
    public function getIdUserLog(){
        return $this->id_user_log;
    }
    public function setActionLog($action_log){
        $this->action_log = $action_log;
    }
    public function getActionLog(){
        return $this->action_log;
    }
    public function setApartadoLog($apartado_log){
        $this->apartado_log = $apartado_log;
    }
    public function getApartadoLog(){
        return $this->apartado_log;
    }
    public function setIdApartadoLog($id_apartado_log){
        $this->id_apartado_log = $id_apartado_log;
    }
    public function getIdApartadoLog(){
        return $this->id_apartado_log;
    }
    public function setFechaLog($fecha_log){
        $this->fecha_log = $fecha_log;
    }
    public function getFechaLog(){
        return $this->fecha_log;
    }
    
}

?>