<?php
include_once "config/dataBase.php";
include_once "models/categorias/CategoriaProducto.php";

class CategoriaProductoDAO {
    public static function getAllCategoriaProducto() {
        $con = DataBase::Connect();
        $stmt = $con->prepare("SELECT * FROM categoria_producto");

        $stmt->execute();
        $result = $stmt->get_result();

        $categorias = [];
        while ($categoria = $result->fetch_object('CategoriaProducto')) {
            $categorias[] = [
                'id_categoria_producto' => $categoria->getId_categoria_producto(),
                'nombre_categoria_producto' => $categoria->getNombre_categoria_producto(),
            ];
        }

        $con->close();
        return $categorias;
    }

    public static function getCategoriaProductoById($id) {
        $con = DataBase::Connect();
        $stmt = $con->prepare("SELECT * FROM categoria_producto WHERE id_categoria_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $categoriaId = $result->fetch_object('CategoriaProducto');

        $con->close();
        return $categoriaId;
    }

}
?>