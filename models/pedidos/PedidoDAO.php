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
                'id_oferta_' => $pedido->getId_oferta_pedido() ?? 0
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
                'metodo_pago' => $row['metodo_pago'],
                'id_oferta_' => $row['id_oferta_']
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
    
    
    public static function insertarPedido($idUser, $direccion, $metodoPago, $id_oferta_cesta, $productos) {
        $con = DataBase::connect();
        
        // Calcular el precio total del pedido
        $precioTotal = 0;
        foreach ($productos as $producto) {
            // Simplemente tomar el precio del producto tal cual viene, sin aplicar descuento
            $precioTotal += $producto['precio_producto'] * $producto['cantidad'];
        }
        
        // Si no hay un id_oferta_cesta, se deja como NULL (es decir, no se aplica ninguna oferta)
        if (!$id_oferta_cesta) {
            $id_oferta_cesta = null;
        }
        
        // Insertar el pedido en la tabla 'pedidos'
        $sqlInsertPedido = "
            INSERT INTO pedidos 
            (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago, id_oferta_) 
            VALUES 
            (NOW(), 'Pendiente', ?, ?, ?, ?, ?)
        ";
        $stmtPedido = $con->prepare($sqlInsertPedido);
        $stmtPedido->bind_param("idssi", $idUser, $precioTotal, $direccion, $metodoPago, $id_oferta_cesta);
        $stmtPedido->execute();
        
        // Obtener el ID del pedido insertado
        $idPedido = $con->insert_id;
        
        // Insertar los productos del pedido en la tabla 'pedido_productos'
        $sqlInsertProductos = "
            INSERT INTO pedido_productos 
            (id__pedido, id_producto_, cantidad_producto, tamaño_producto, precio__producto) 
            VALUES 
            (?, ?, ?, ?, ?)
        ";
        $stmtProductos = $con->prepare($sqlInsertProductos);
        
        foreach ($productos as $producto) {
            // Tomar el precio del producto tal como viene (ya viene con el descuento si lo tiene)
            $precioFinalProducto = $producto['precio_producto'];
    
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
        
        // Confirmar la transacción
        $con->commit();
        
        // Cerrar la conexión
        $con->close();
        
        // Retornar una respuesta exitosa
        return [
            "success" => true,
            "id_pedido" => $idPedido,
            "message" => "Pedido creado correctamente."
        ];
    }
    
    public static function getPedidoById($idPedido){
        $con = DataBase::connect();

        $sql = "SELECT * FROM pedidos WHERE id_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedido = $result->fetch_object("Pedido");

        $con->close();
        return $pedido;
    }

    public static function updatePedido($idPedido, $fechaPedido, $estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago) {
        $con = DataBase::connect();
    
        $sql = "UPDATE pedidos 
                SET fecha_pedido = ?, 
                    estado_pedido = ?, 
                    id_user_pedido = ?, 
                    precio_pedido = ?, 
                    direccion_pedido = ?, 
                    metodo_pago = ?
                    
                WHERE id_pedido = ?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssidssi", 
            $fechaPedido, 
            $estadoPedido, 
            $idUserPedido, 
            $precioPedido, 
            $direccionPedido, 
            $metodoPago, 
            $idPedido
        );
    
        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();
    
        return $resultado;
    }
    
    

    public static function deletePedido($idPedido){
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
        $stmt->bind_param("i", $idPedido);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }
    
    public static function createPedido($estadoPedido, $id_user_pedido, $precio_pedido, $direccion_pedido, $metodo_pago){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO pedidos (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago) VALUES (NOW(), ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $estadoPedido, $id_user_pedido, $precio_pedido, $direccion_pedido, $metodo_pago);
        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();

        return $resultado;
    }
    
}
?>