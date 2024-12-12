<?php
include_once "config/dataBase.php";
include_once "models/pedidos/Pedido.php";

class PedidoDAO{
    public static function getPedidos($idUser) {
        $con = DataBase::connect();
        $sql = "SELECT * FROM pedidos WHERE id_user_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = new Pedido(
                $row['id_pedido'],
                $row['fecha_pedido'],
                $row['estado_pedido'],
                $row['id_user_pedido'],
                $row['precio_pedido'],
                $row['direccion_pedido'],
                $row['metodo_pago']
            );
        }
        return $pedidos;
    }

    public static function insertarPedido($idUser, $direccion, $metodoPago) {
        $con = DataBase::connect();

        $con->begin_transaction();
        $productos = CestaDAO::getCesta($idUser); 

        $precioTotal = 0;
        foreach ($productos as $producto) {
            $precioTotal += $producto['precio_producto'] * $producto['cantidad'];
        }

        $sqlInsertPedido = "
            INSERT INTO pedidos 
            (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago) 
            VALUES 
            (NOW(), 'Pendiente', ?, ?, ?, ?)
        ";
        $stmtPedido = $con->prepare($sqlInsertPedido);
        $stmtPedido->bind_param("idss", $idUser, $precioTotal, $direccion, $metodoPago);
        $stmtPedido->execute();

        $idPedido = $con->insert_id;

        $sqlInsertProductos = "
            INSERT INTO pedido_productos 
            (id__pedido, id_producto_, cantidad_producto, tamaño_producto, precio__producto) 
            VALUES 
            (?, ?, ?, ?, ?)
        ";
        $stmtProductos = $con->prepare($sqlInsertProductos);

        foreach ($productos as $producto) {
            $stmtProductos->bind_param(
                "iiisd",
                $idPedido,
                $producto['id_producto'],
                $producto['cantidad'],
                $producto['tamaño'],
                $producto['precio_producto']
            );
            $stmtProductos->execute();
        }
        $sqlVaciarCesta = "DELETE FROM cesta WHERE id__user = ?";
        $stmtVaciarCesta = $con->prepare($sqlVaciarCesta);
        $stmtVaciarCesta->bind_param("i", $idUser);
        $stmtVaciarCesta->execute();

        $con->commit();

        return [
            "success" => true,
            "id_pedido" => $idPedido,
            "message" => "Pedido creado correctamente."
        ];
        $con->close();
    
    }
}
?>