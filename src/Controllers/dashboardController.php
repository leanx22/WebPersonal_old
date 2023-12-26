<?php
namespace App\Controllers;

require_once __DIR__.'/../extra/estadisticas/Estadisticas.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;

class DashboardController{

    static function getDashboard(Request $peticion, Response $respuesta)
    {

        $args = array();         
        $view = Twig::fromRequest($peticion);
        return $view->render($respuesta, 'dashboard.html', $args);
    }

}