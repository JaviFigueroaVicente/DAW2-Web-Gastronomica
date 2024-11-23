<?php
include_once "config/dataBase.php";
include_once "models/pedidos/Pedido.php";

class PedidoDAO{
    public function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PEDIDOS");

        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];
        while($pedido = $result->fetch_object("Pedido")){
            $pedidos[] = $pedido;
        }

        $con->close();
        return $pedidos;
    }
}
?>