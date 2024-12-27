<?php
include_once "config/dataBase.php";
include_once "models/pedidos/Pedido.php";

class PedidoDAO{
    public static function getAllPedidos() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM pedidos");
        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];
        while ($pedido = $result->fetch_object("Pedido")) {
            $pedidos[] = [
                'id_pedido' => $pedido->getId_pedido(),
                'fecha_pedido' => $pedido ->getFecha_Pedido(),
                'estado_pedido' => $pedido->getEstado_pedido(),
                'id_user_pedido' => $pedido->getId_user_pedido(),
                'precio_pedido' => $pedido->getPrecio_pedido(),
                'direccion_pedido' => $pedido->getDireccion_pedido(),
                'metodo_pago' => $pedido->getMetodo_pago(),
                'id_oferta_' => $pedido->getId_oferta_pedido()
            ];
        }

        $con->close();
        return $pedidos;
    }

    public static function getPedidos($idUser) {
        $con = DataBase::connect();

        $sql = "SELECT * FROM pedidos WHERE id_user_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = [
                'id_pedido' => $row['id_pedido'],
                'fecha_pedido' => $row['fecha_pedido'],
                'estado_pedido' => $row['estado_pedido'],
                'precio_pedido' => $row['precio_pedido'],
                'direccion_pedido' => $row['direccion_pedido'],
                'metodo_pago' => $row['metodo_pago']
            ];
        }

        $con->close();
        return $pedidos;
    }

    public static function getPedidoIndividual($idPedido) {
        $con = DataBase::connect();
        $sql = "
            SELECT 
                pp.id_pedido_productos,
                pp.id__pedido,
                pp.id_producto_,
                pp.cantidad_producto,
                pp.tamaño_producto,
                pp.precio__producto,
                p.nombre_producto,
                p.foto_producto
                
            FROM 
                pedido_productos pp
            INNER JOIN 
                productos p 
            ON 
                pp.id_producto_ = p.id_producto
            WHERE 
                pp.id__pedido = ?
        ";
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = [
                'id_producto' => $row['id_producto_'],
                'nombre_producto' => $row['nombre_producto'],
                'cantidad_producto' => $row['cantidad_producto'],
                'tamaño_producto' => $row['tamaño_producto'],
                'precio_producto' => $row['precio__producto'],
                'foto_producto' => $row['foto_producto']
            ];
        }
    
        $con->close();
        return $productos;
    }
    
    
    
    public static function insertarPedido($idUser, $direccion, $metodoPago, $id_oferta_cesta) {
        $con = DataBase::connect();
        $productos = CestaDAO::getCesta($idUser); 
        
        $precioTotal = 0;
        foreach ($productos as $producto) {
            $descuento = $producto['id__oferta'] ? (1 - ($producto['descuento_oferta'] / 100)) : 1;
            $precioTotal += $producto['precio_producto'] * $producto['cantidad'] * $descuento;
        }

        $sqlInsertPedido = "
            INSERT INTO pedidos 
            (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago, id_oferta_) 
            VALUES 
            (NOW(), 'Pendiente', ?, ?, ?, ?, ?)
        ";
        $stmtPedido = $con->prepare($sqlInsertPedido);
        $stmtPedido->bind_param("idssi", $idUser, $precioTotal, $direccion, $metodoPago, $id_oferta_cesta);
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
            $precioFinalProducto = $producto['precio_producto'] * (1 - ($producto['descuento_oferta'] / 100));
            $stmtProductos->bind_param(
                "iiisd",
                $idPedido,
                $producto['id_producto'],
                $producto['cantidad'],
                $producto['tamaño'],
                $precioFinalProducto
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

    public static function updatePedido($idPedido, $estadoPedido){
        $con = DataBase::connect();

        $sql = "UPDATE pedidos SET estado_pedido = ? WHERE id_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $estadoPedido, $idPedido);
        $stmt->execute();

        $con->close();
    }

    public static function deletePedido($idPedido){
        $con = DataBase::connect();

        $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();

        $con->close();
    }
    
    public static function createPedido($pedido){
        $con = DataBase::connect();

        $sql = "INSERT INTO pedidos (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssids", $pedido->fecha_pedido, $pedido->estado_pedido, $pedido->id_user_pedido, $pedido->precio_pedido, $pedido->direccion_pedido, $pedido->metodo_pago);
        $stmt->execute();

        $con->close();
    }
    
}
?>