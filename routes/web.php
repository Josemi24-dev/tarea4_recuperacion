<!-- Este archivo define las rutas web que van a usar 
 los controladores para manejar peticiones -->

<?php
declare(strict_types=1);

$auth = new AuthController();
$salaCtrl = new SalaController();

// Obtenemos la ruta desde la URL
$url = $_SERVER['REQUEST_URI'];
$uri = explode('?', $url)[0]; // Elimina los parámetros

switch ($uri) {
    case '/':
        require_once __DIR__ . '/../resources/views/login.php';
        break;

    case '/crear-bd':
        require_once __DIR__ . '/../scripts/crear_bd.php';
        break;

    case '/login':
    $_SERVER['REQUEST_METHOD'] === 'POST'
        ? $auth->login()        // si se accede mediante POST, procesa el formulario
        : $auth->loginForm();   // si se accede mediante GET, muestra el formulario
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

case '/confirmar-compra':
    $salaCtrl->confirmarCompra();
    break;

// /usuario/{id}
case (preg_match('#^/usuario/(\d+)$#', $uri, $matches) ? true : false):
    $id = (int) $matches[1];    // captura la id del usuario
    $controller = new UsuarioController();
    $controller->mostrar($id);  // muestra el panel del usuario
    break;

// /sala/{id}
case (preg_match('#^/sala/(\d+)$#', $uri, $matches) ? true : false):
    // Carga los asientos disponibles para la sala especificada
    $salaCtrl->verAsientos((int)$matches[1]);
    break;

// /usuario/{id}/editar
case (preg_match('#^/usuario/(\d+)/editar$#', $uri, $matches) ? true : false):
    $id = (int) $matches[1];
    // Si es POST, actualiza los datos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UsuarioController();
        $controller->actualizar($id);
    } else {
        // Si es GET, muestra el formulario
        $controller = new UsuarioController();
        $controller->editar($id);
    }
    break;

case '/cuenta-cine':
    $db = Database::connect();
    // Consulta a la BD para mostrar el saldo acumulado del cine
    $saldo = $db->query("SELECT saldo_total FROM cuenta_cine WHERE id = 1")->fetchColumn();
    echo "<h2>Cuenta del Cine</h2><p>Recaudado: €$saldo</p>";
    break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../resources/views/404.php';
        break;
}
