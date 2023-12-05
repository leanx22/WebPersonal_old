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

$app = AppFactory::create();

$vistas = Twig::create(__DIR__.'/../Views', ['args'=>false]);
$app->add(TwigMiddleware::create($app,$vistas));//2args a quien y que

$app->get('/', HomeController::class . '::index');

$app->run();
