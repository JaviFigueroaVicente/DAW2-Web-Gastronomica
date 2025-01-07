<?php
include_once "config/dataBase.php";
include_once "models/pedidos/Pedido.php";

class PedidoDAO {

    // Método para obtener todos los pedidos desde la base de datos
    public static function getAllPedidos() {
        // Establecer la conexión con la base de datos
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para obtener todos los pedidos
        $stmt = $con->prepare("SELECT * FROM pedidos");
        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];
        // Recorrer cada pedido en el resultado y almacenarlo en un array
        while ($pedido = $result->fetch_object("Pedido")) {
            $pedidos[] = [
                'id_pedido' => $pedido->getId_pedido(),
                'fecha_pedido' => $pedido->getFecha_Pedido(),
                'estado_pedido' => $pedido->getEstado_pedido(),
                'id_user_pedido' => $pedido->getId_user_pedido(),
                'precio_pedido' => $pedido->getPrecio_pedido(),
                'direccion_pedido' => $pedido->getDireccion_pedido(),
                'metodo_pago' => $pedido->getMetodo_pago(),
                'id_oferta_' => $pedido->getId_oferta_pedido() ?? 0
            ];
        }

        // Cerrar la conexión y devolver el array de pedidos
        $con->close();
        return $pedidos;
    }

    // Método para obtener todos los pedidos de un usuario específico
    public static function getPedidos($idUser) {
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para obtener los pedidos de un usuario
        $sql = "SELECT * FROM pedidos WHERE id_user_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidos = [];
        
        // Recorrer cada pedido y almacenarlo en un array
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

        // Cerrar la conexión y devolver el array de pedidos
        $con->close();
        return $pedidos;
    }

    // Método para obtener los detalles de un pedido específico (productos en el pedido)
    public static function getPedidoIndividual($idPedido) {
        $con = DataBase::connect();
        
        // Preparar y ejecutar la consulta para obtener los productos de un pedido específico
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
        // Recorrer los productos y almacenarlos en un array
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

        // Cerrar la conexión y devolver el array de productos
        $con->close();
        return $productos;
    }

    // Método para insertar un nuevo pedido en la base de datos
    public static function insertarPedido($idUser, $direccion, $metodoPago, $id_oferta_cesta) {
        // Conexión a la base de datos
        $con = DataBase::connect();
    
        // Obtener los productos de la cesta del usuario
        $productos = CestaDAO::getCesta($idUser);
        if (empty($productos)) {
            die("Error: La cesta está vacía.");
        }
    
        // Calcular el precio total del pedido, aplicando los descuentos si existen
        $precioTotal = 0;
        foreach ($productos as $producto) {
            $descuento = $producto['id__oferta'] ? (1 - ($producto['descuento_oferta'] / 100)) : 1;
            $precioTotal += $producto['precio_producto'] * $producto['cantidad'] * $descuento;
        }
    
        // Insertar el pedido en la base de datos
        $sqlInsertPedido = "
            INSERT INTO pedidos 
            (fecha_pedido, estado_pedido, id_user_pedido, precio_pedido, direccion_pedido, metodo_pago, id_oferta_) 
            VALUES 
            (NOW(), 'Pendiente', ?, ?, ?, ?, ?)
        ";
    
        $stmtPedido = $con->prepare($sqlInsertPedido);
        $stmtPedido->bind_param("idssi", $idUser, $precioTotal, $direccion, $metodoPago, $id_oferta_cesta);
        $stmtPedido->execute();
    
        if ($stmtPedido->affected_rows === 0) {
            die("Error: No se pudo insertar el pedido.");
        }
    
        $idPedido = $con->insert_id;
    
        // Insertar los productos en la tabla pedido_productos
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
    
        // Vaciar la cesta del usuario después de realizar el pedido
        $sqlVaciarCesta = "DELETE FROM cesta WHERE id__user = ?";
        $stmtVaciarCesta = $con->prepare($sqlVaciarCesta);
        $stmtVaciarCesta->bind_param("i", $idUser);
        $stmtVaciarCesta->execute();
    
        // Confirmar la transacción
        $con->commit();
    
        // Cerrar la conexión
        $con->close();
    
        return [
            "success" => true,
            "id_pedido" => $idPedido,
            "message" => "Pedido creado correctamente."
        ];
    }
    

    // Método para obtener un pedido específico por su ID
    public static function getPedidoById($idPedido){
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para obtener un pedido específico
        $sql = "SELECT * FROM pedidos WHERE id_pedido = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedido = $result->fetch_object("Pedido");

        // Cerrar la conexión y devolver el pedido
        $con->close();
        return $pedido;
    }

    // Método para actualizar los detalles de un pedido
    public static function updatePedido($idPedido, $fechaPedido, $estadoPedido, $idUserPedido, $precioPedido, $direccionPedido, $metodoPago) {
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para actualizar el pedido
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

        // Ejecutar la consulta y cerrar la conexión
        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();

        return $resultado;
    }

    // Método para eliminar un pedido
    public static function deletePedido($idPedido){
        $con = DataBase::connect();

        // Preparar y ejecutar la consulta para eliminar el pedido
        $stmt = $con->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
        $stmt->bind_param("i", $idPedido);
        $resultado = $stmt->execute();

        // Cerrar la conexión y devolver el resultado
        $con->close();
        return $resultado;
    }

    // Método para crear un nuevo pedido (método legado o de respaldo)
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