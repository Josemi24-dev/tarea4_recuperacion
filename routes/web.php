<?php
declare(strict_types=1);

$url = $_SERVER['REQUEST_URI'];
$uri = explode('?', $url)[0]; // Elimina los parámetros

switch ($uri) {
    case '/':
        require_once __DIR__ . '/../resources/views/home.php';
        break;

    case '/crear-bd':
        require_once __DIR__ . '/../scripts/crear_bd.php';
        break;



    default:
        http_response_code(404);
        require_once __DIR__ . '/../resources/views/404.php';
        break;
}
