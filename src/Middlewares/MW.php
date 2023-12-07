<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__.'/../Models/Usuario.php';
require_once __DIR__.'/../extra/JWT/jwt.php';
use App\Models\Usuario;


//Mis middlewares
class MW
{
    
}