<?php
require __DIR__ . '/../../vendor/autoload.php';

use DogtorPET\Backend\Rest\LoginController;
use DogtorPET\Backend\Rest\MascotaController;
use DogtorPET\Backend\Rest\TipoController;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();

// TODO: Configurar intermediarios (middleware) para habilitar las llamadas remotas (CORS)

$app->get('/ws/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

### DESPACHAR LAS LLAMADAS CON EL CONTROLADOR DE LOGIN
$app->get('/ws/login', LoginController::class . ':login');

### DESPACHAR LAS LLAMADAS CON EL CONTROLADOR DE MASCOTA
$app->get('/ws/mascota/{id}', MascotaController::class . ':obtener');
$app->get('/ws/mascota/catalogo/{propietario}', MascotaController::class . ':lista');
$app->post('/ws/mascota', MascotaController::class . ':insertar');
$app->put('/ws/mascota/{id}', MascotaController::class . ':actualizar');
$app->delete('/ws/mascota/{id}', MascotaController::class . ':eliminar');

### DESPACHAR LAS LLAMADAS CON EL CONTROLADOR DE TIPO
$app->get('/ws/tipo', TipoController::class . ':lista');

$app->run();
?>