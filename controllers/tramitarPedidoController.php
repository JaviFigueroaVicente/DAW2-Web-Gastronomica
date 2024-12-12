<?php
include_once 'models/pedidos/PedidoDAO.php';
include_once 'models/cesta/CestaDAO.php';

class TramitarPedidoController{
    public function crearPedido(){
        $idUser = $_SESSION['user_id'];
        $direccion = $_POST['deliveryOption'];
        $metodoPago = $_POST['PayOption'];

        $resultado = PedidoDAO::insertarPedido($idUser, $direccion, $metodoPago);

        header ("Location: ?url=index");
    }
}
?>