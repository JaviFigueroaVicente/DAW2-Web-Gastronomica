<?php
include_once "config/dataBase.php";
include_once "models/cesta/Cesta.php";
include_once "models/cesta/Cupon.php";

class CestaDAO{   
    public static function countTotal($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT SUM(cantidad) as total_cesta FROM cesta WHERE id__user = $id");


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
        
        $sql = "
            SELECT 
                c.id_fila_cesta,
                c.id__user,
                c.id__producto,            
                c.cantidad,    
                c.tamaño, 
                c.id__oferta,       
                p.nombre_producto,           
                p.precio_producto,
                p.foto_producto,
                p.stock_producto,
                o.descuento_oferta                           
            FROM 
                cesta c
            INNER JOIN 
                productos p 
            ON 
                c.id__producto = p.id_producto
            LEFT JOIN 
                ofertas o
            ON 
                c.id__oferta = o.id_oferta
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
                'stock_producto' => $row['stock_producto'],
                'id__oferta' => $row['id__oferta'],
                'descuento_oferta' => $row['descuento_oferta'] ?? null
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

    public static function getAllCupones(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas");

        $stmt->execute();
        $result = $stmt->get_result();

        $ofertas = [];
        while($data = $result->fetch_object()){
            $oferta = new Cupon();
            $oferta->setId_oferta($data->id_oferta);
            $oferta->setNombre_oferta($data->nombre_oferta);
            $oferta->setDescripcion_oferta($data->descripcion_oferta);
            $oferta->setDescuento_oferta($data->descuento_oferta);
            $oferta->setFecha_inicio_oferta($data->fecha_inicio_oferta);
            $oferta->setFecha_fin_oferta($data->fecha_fin_oferta);
            
            $ofertas[] = $oferta;
        }

        $con->close();
        return $ofertas;
    }

    public static function updateCupon($cupon, $id_user) {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE cesta SET id__oferta = ? WHERE id__user = ?");
        
        $id_cupon = $cupon->getId_oferta(); 
    
        $stmt->bind_param("ii", $id_cupon, $id_user);
        $stmt->execute();
    
        $con->close();
    
        return true; 
    }
}
?>