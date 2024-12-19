<?php
include_once "models/pedidos/PedidoDAO.php";
include_once "models/cesta/CestaDAO.php";

class PedidoController{
    public function comprar(){
        $cesta = CestaDAO::getCesta($_SESSION['user_id']);
        include_once "views/comprar.php";
    }    

    public function misPedidos(){
        $pedidosUser = PedidoDAO::getPedidos($_SESSION['user_id']);
        include_once 'views/mis-pedidos.php';
    }

    public function pedidoInidividual(){
        $pedidoIndividual = PedidoDAO::getPedidoIndividual($_GET['id_pedido']);
        include_once "views/pedido-individual.php";
    }


    public function crearPedido(){
        $idUser = $_SESSION['user_id'];
        $direccion = $_POST['deliveryOption'];
        $metodoPago = $_POST['PayOption'];
        $id_oferta = $_POST['id_oferta'];

        $resultado = PedidoDAO::insertarPedido($idUser, $direccion, $metodoPago, $id_oferta);

        header ("Location: ?url=index");
    }
    
}
?>