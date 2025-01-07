<?php
include_once "config/dataBase.php";
include_once "models/categorias/CategoriaProducto.php";

class CategoriaProductoDAO {

    // Obtener todas las categorías de productos desde la base de datos
    public static function getAllCategoriaProducto() {
        // Conectar a la base de datos
        $con = DataBase::Connect();
        // Preparar la consulta para obtener todas las categorías de producto
        $stmt = $con->prepare("SELECT * FROM categoria_producto");

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        $categorias = [];
        // Recorrer los resultados y almacenar cada categoría en un array
        while ($categoria = $result->fetch_object('CategoriaProducto')) {
            $categorias[] = [
                'id_categoria_producto' => $categoria->getId_categoria_producto(),
                'nombre_categoria_producto' => $categoria->getNombre_categoria_producto(),
            ];
        }

        // Cerrar la conexión
        $con->close();
        // Devolver el array de categorías
        return $categorias;
    }

    // Obtener una categoría de producto por su ID
    public static function getCategoriaProductoById($id) {
        // Conectar a la base de datos
        $con = DataBase::Connect();
        // Preparar la consulta para obtener una categoría por ID
        $stmt = $con->prepare("SELECT * FROM categoria_producto WHERE id_categoria_producto = ?");
        // Vincular el parámetro de entrada
        $stmt->bind_param("i", $id);
        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();
    
        $categoria = [];
        // Si la categoría existe, almacenar los datos en un array asociativo
        if ($row = $result->fetch_assoc()) {
            $categoria = [
                'id_categoria_producto' => $row['id_categoria_producto'],
                'nombre_categoria_producto' => $row['nombre_categoria_producto'],
            ];
        }
    
        // Cerrar la conexión
        $con->close();
        // Devolver el array de la categoría
        return $categoria;
    }
}
?>
