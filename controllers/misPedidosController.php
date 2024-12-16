<?php
include_once "models/pedidos/PedidoDAO.php";

class MisPedidosController{
    public function misPedidos(){
        $pedidosUser = PedidoDAO::getPedidos($_SESSION['user_id']);
        include_once 'views/mis-pedidos.php';
    }
}
?>