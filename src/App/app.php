<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy; //para grupos

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__.'/../Controllers/homeController.php';
use App\Controllers\HomeController;

require_once __DIR__.'/../Controllers/loginController.php';
use App\Controllers\loginController;
use App\extra\estadisticas\Estadisticas;

require_once __DIR__.'/../Controllers/dashboardController.php';
use App\Controllers\DashboardController;

require_once __DIR__.'/../Models/Usuario.php';
use App\Models\Usuario;

require_once __DIR__.'/../Middlewares/MW.php';

$app = AppFactory::create();

$vistas = Twig::create(__DIR__.'/../Views', ['args'=>false]);
$app->add(TwigMiddleware::create($app,$vistas));//2args a quien y que

//LAZY CORS//
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'https://leandev.000webhostapp.com/estadisticas/general')
            ->withHeader('Access-Control-Allow-Origin', 'https://leandev.000webhostapp.com/estadisticas/github')
            ->withHeader('Access-Control-Allow-Origin', 'https://leandev.000webhostapp.com/estadisticas/linkedin')
            ->withHeader('Access-Control-Allow-Origin', 'https://leandev.000webhostapp.com/estadisticas/cv')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost/')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH');
});
//LAZY CORS//

$app->get('/', HomeController::class . '::index');
$app->get('/login', loginController::class . '::cargarVistaLogIn');

$app->post('/login', Usuario::class . '::login')
->add(MW::class.":validarUsuarioExistente");

$app->get('/dashboard', DashboardController::class . '::getDashboard');

$app->group('/estadisticas', function(RouteCollectorProxy $grupo){

    $grupo->post('/general', Estadisticas::class . ":sumarVistaGeneral");
    $grupo->post('/github', Estadisticas::class . ":sumarVistaGitHub");
    $grupo->post('/linkedin', Estadisticas::class . ":sumarVistaLinkedIn");
    $grupo->post('/cv', Estadisticas::class . ":sumarVistaCV");
});

//mW->que me cree la JWT
//mW->que el usuario exista en base, y me cree una propiedad / stdclass que contenga todos los datos.

$app->run();
