<?php
include_once "config/dataBase.php";
include_once "models/cesta/Cesta.php";

class CestaDAO{
    public static function countTotal($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT COUNT(*) as total_cesta FROM cesta WHERE id__user = $id");

        $stmt->execute();
        $result = $stmt->get_result();        
        $total = $result->fetch_assoc();
        
        $con->close();
        return $total['total_cesta'];
    }
    public static function existeProductoCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM cesta WHERE id__user = ? AND id__producto = ?");
        
        $id_user = $cesta -> getIdUser();
        $id_producto = $cesta -> getIdProducto();
        
        $stmt->bind_param("ii", $id_user, $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result->num_rows > 0;
    }


    public static function getCesta($id){
        $con = DataBase::connect();
        
        // Consulta para obtener los datos de la tabla cesta con los detalles del producto
        $sql = "
            SELECT 
                c.id_fila_cesta,
                c.id__user,
                c.id__producto,            
                c.cantidad,    
                c.tamaño,        
                p.nombre_producto,           
                p.precio_producto,
                p.foto_producto,
                p.stock_producto            
            FROM 
                cesta c
            INNER JOIN 
                productos p 
            ON 
                c.id__producto = p.id_producto
            WHERE 
                c.id__user = ?
        ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $cesta = [];
        while ($row = $result->fetch_assoc()) {
            $cesta[] = [
                'id_fila_cesta' => $row['id_fila_cesta'],            
                'id_user' => $row['id__user'],
                'id_producto' => $row['id__producto'],
                'cantidad' => $row['cantidad'],   
                'tamaño' => $row['tamaño'],         
                'nombre_producto' => $row['nombre_producto'],            
                'precio_producto' => $row['precio_producto'],
                'foto_producto' => $row['foto_producto'],
                'stock_producto' => $row['stock_producto']
            ];
        }

        $con->close();
        return $cesta;
    }
    
    public static function insertarCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO cesta(id__user, id__producto, cantidad, tamaño) VALUES (?,?,?,?)");

        $user_id = $cesta -> getIdUser();
        $producto_id = $cesta -> getIdProducto();
        $cantidad = $cesta -> getCantidad();
        $tamaño = $cesta -> getTamaño();
        
        $stmt->bind_param("iiis", $user_id, $producto_id, $cantidad, $tamaño);

        $stmt->execute();
        $con->close();
        
    }

    public static function eliminarProductoCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM cesta WHERE id__producto = ? AND id__user = ?");

        $id_producto = $cesta -> getIdProducto();
        $id_user = $cesta -> getIdUser();

        $stmt->bind_param("ii",$id_producto, $id_user);

        $stmt->execute();
        $con->close();
    }

    public static function vaciarCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM cesta WHERE id__user = ?");

        $id = $cesta -> getIdUser();

        $stmt->bind_param("i", $id);

        $stmt->execute();
        $con->close();
    }

    public static function actualizarCantidadProductoCesta($cesta){
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE cesta SET cantidad = ?, tamaño = ? WHERE id__producto = ? AND id__user = ?");

        $cantidad = $cesta -> getCantidad();
        $id_producto = $cesta -> getIdProducto();
        $id_user = $cesta -> getIdUser();
        $tamaño = $cesta -> getTamaño();

        $stmt->bind_param("isii", $cantidad, $tamaño, $id_producto, $id_user);

        $stmt->execute();
        $con->close();
    }
}
?>