<?php
// Se incluyen los archivos necesarios para interactuar con la base de datos de productos, categorías y cesta
include_once "models/productos/ProductosDAO.php";
include_once "models/categorias/CategoriaProductoDAO.php";
include_once "models/cesta/CestaDAO.php";

// Definición del controlador ProductoController
class ProductoController{
    
    // Método para mostrar todos los productos
    public function productos(){
        // Obtiene el criterio de ordenación desde la URL, si está presente
        $orden = isset($_GET['ordenar']) ? $_GET['ordenar'] : null;
        
        // Llama al DAO para obtener los productos y categorías
        $productos = ProductosDAO::getAll($orden);
        $categoriasProducto = CategoriaProductoDAO::getAllCategoriaProducto();
        $total_productos = ProductosDAO::countAll();
        
        // Incluye la vista para mostrar los productos
        include_once 'views/productos.php';
    }
    
    // Método para mostrar un producto individual
    public function productoIndividual(){
        // Obtiene el ID del producto desde la URL
        $id = intval($_GET['id']);
        
        // Llama al DAO para obtener los detalles del producto y su categoría
        $productoIndividual = ProductosDAO::getProductoIndividual($id);
        $id_categoria = $productoIndividual['id_categoria_producto'];
        $categoriaId = CategoriaProductoDAO::getCategoriaProductoById($id_categoria);
        
        // Incluye la vista para mostrar el producto individual
        include_once 'views/producto-individual.php';        
    }

    // Método para mostrar productos filtrados por categoría
    public function productosByCategoria(){
        // Obtiene el ID de la categoría desde la URL
        $id = intval($_GET['categoria']);
        // Obtiene el criterio de ordenación desde la URL, si está presente
        $orden = isset($_GET['ordenar']) ? $_GET['ordenar'] : null;
        
        // Llama al DAO para obtener los productos de la categoría
        $productos = ProductosDAO::getProductosByCategoria($id, $orden);
        $total_productos = ProductosDAO::countProductosByCategoria($id);
        $categoriasProducto = CategoriaProductoDAO::getAllCategoriaProducto();
        $categoriaId = CategoriaProductoDAO::getCategoriaProductoById($id);
        
        // Incluye la vista para mostrar los productos filtrados por categoría
        include_once 'views/productos.php';
    }

    // Método para mostrar productos basados en una búsqueda
    public function productosByBusqueda(){
        // Obtiene el término de búsqueda desde la URL
        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : null;
        
        // Llama al DAO para obtener los productos encontrados por la búsqueda
        $productos = ProductosDAO::getProductosByBusqueda($busqueda);
        $total_productos = ProductosDAO::countProductosByBusqueda($busqueda);
        
        // Incluye la vista para mostrar los productos encontrados
        include_once 'views/productos.php';
    }
}
?>
