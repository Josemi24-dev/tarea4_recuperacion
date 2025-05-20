<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/SalaController.php';
$auth = new AuthController();
$salaCtrl = new SalaController();

$url = $_SERVER['REQUEST_URI'];
$uri = explode('?', $url)[0]; // Elimina los parámetros

switch ($uri) {
    case '/':
        require_once __DIR__ . '/../resources/views/home.php';
        break;

    case '/crear-bd':
        require_once __DIR__ . '/../scripts/crear_bd.php';
        break;

    case '/login':
    $_SERVER['REQUEST_METHOD'] === 'POST'
        ? $auth->login()
        : $auth->loginForm();
    break;

case '/registro':
    $_SERVER['REQUEST_METHOD'] === 'POST'
        ? $auth->register()
        : $auth->registerForm();
    break;

case '/logout':
    $auth->logout();
    break;

case '/salas':
    $salaCtrl->listar();
    break;

case '/resumen-compra':
    $salaCtrl->resumenCompra();
    break;

case (preg_match('#^/usuario/(\d+)$#', $uri, $matches) ? true : false):
    $id = (int) $matches[1];
    require_once __DIR__ . '/../app/Controllers/UsuarioController.php';
    $controller = new UsuarioController();
    $controller->mostrar($id);
    break;

case (preg_match('#^/sala/(\d+)$#', $uri, $matches) ? true : false):
    $salaCtrl->verAsientos((int)$matches[1]);
    break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../resources/views/404.php';
        break;
}
