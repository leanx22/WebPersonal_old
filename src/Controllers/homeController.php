<?php
namespace App\Controllers;

require_once __DIR__.'/../Models/Proyecto.php';
require_once __DIR__.'/../Models/Badge.php';
require_once __DIR__.'/../extra/estadisticas/Estadisticas.php';

use App\Models\Proyecto;
use App\Models\Badge;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;

class HomeController{

    static function index(Request $peticion, Response $respuesta)
    {
        $proyectos = Proyecto::obtenerSoloActivos();
        $badges = Badge::obtenerTodas();
        $args = array(
            "proyectos"=>$proyectos,
            "badges"=>$badges
        );         
        $view = Twig::fromRequest($peticion);
        return $view->render($respuesta, 'index.html', $args);
    }

}