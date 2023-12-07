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

require_once __DIR__.'/../Models/Usuario.php';
use App\Models\Usuario;

require_once __DIR__.'/../Middlewares/MW.php';

$app = AppFactory::create();

$vistas = Twig::create(__DIR__.'/../Views', ['args'=>false]);
$app->add(TwigMiddleware::create($app,$vistas));//2args a quien y que

$app->get('/', HomeController::class . '::index');
$app->get('/login', loginController::class . '::cargarVistaLogIn');

$app->post('/login', Usuario::class . '::login')
->add(MW::class.":validarUsuarioExistente");
//mW->que me cree la JWT
//mW->que el usuario exista en base, y me cree una propiedad / stdclass que contenga todos los datos.
$app->run();
