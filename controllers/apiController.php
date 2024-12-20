<?php
include_once "config/dataBase.php";
include_once "models/users/UserDAO.php";
include_once "models/productos/ProductosDAO.php";
include_once "models/pedidos/PedidoDAO.php";

class ApiController{
    public function admin(){
        include_once "views/admin.php";
    }

    public function productosAPI(){
        $productos = ProductosDAO::getAll();
        header('Content-Type: application/json');
        echo json_encode($productos, JSON_UNESCAPED_UNICODE);
    }

    public function usersAPI(){        
        $users = UserDAO::getAllUsers(true);
        header('Content-Type: application/json');
        echo json_encode($users, JSON_UNESCAPED_UNICODE);   
    }

    public function pedidosAPI(){
        $pedidos = PedidoDAO::getAllPedidos();
        header('Content-Type: application/json');
        echo json_encode($pedidos, JSON_UNESCAPED_UNICODE);
    }
}

?>