<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;

class loginController{

    static function cargarVistaLogIn(Request $peticion, Response $respuesta)
    {
        $args = array();        
        $view = Twig::fromRequest($peticion);
        return $view->render($respuesta, 'login.html', $args);
    }

}