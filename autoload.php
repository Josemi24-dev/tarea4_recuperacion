<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $paths = [
        'app/Models/',
        'app/Controllers/',
        'app/Entities/',
        'core/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
