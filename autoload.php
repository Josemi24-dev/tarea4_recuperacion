<!-- Fichero que se encarga de cargar automáticamente las 
 clases PHP necesarias -->

<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/Controllers/',
        __DIR__ . '/config/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
