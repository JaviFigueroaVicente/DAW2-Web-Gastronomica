<?php
    include_once "models/pedidos/PedidoDAO.php";

    class PedidoIndividualController{
        public function pedidoInidividual(){
            $pedidoIndividual = PedidoDAO::getPedidoIndividual($_GET['id_pedido']);
            include_once "views/pedido-individual.php";
        }
    }
?>