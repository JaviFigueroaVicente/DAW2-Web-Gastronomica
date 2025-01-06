<?php
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../'; // Directorio base donde se encuentran las clases
    
    // Si la clase está en el controlador, buscamos en /controllers/
    if (strpos($class, 'Controller') !== false) {
        $file = $baseDir . 'controllers/' . $class . '.php';
    }
    // Si la clase está en el modelo, buscamos en /models/
    elseif (strpos($class, 'Model') !== false) {
        $file = $baseDir . 'models/' . $class . '.php';
    }
    // Si es una clase de base o común, la buscamos en /core/
    else {
        $file = $baseDir . 'core/' . $class . '.php';
    }

    // Si existe el archivo, lo incluimos
    if (file_exists($file)) {
        require_once $file;
    }
});
