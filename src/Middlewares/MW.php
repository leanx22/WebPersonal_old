<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__.'/../Models/Usuario.php';
require_once __DIR__.'/../extra/JWT/jwt.php';
use App\Models\Usuario;
use Firebase\JWT;

//Mis middlewares
class MW
{
    public function validarUsuarioExistente(Request $peticion, RequestHandler $handler):ResponseMW
    {
        $datos = $peticion->getParsedBody();
        $respuesta = new ResponseMW();

        $usuario = Usuario::obtenerUsuarioDesdeBBDD($datos);
        if($usuario->exito == false)
        {
            $array_retorno = array(
                "mensaje"=>"Credenciales incorrectas o usuario inexistente.",
                "status"=>404
            );           
            $respuesta = $respuesta->withStatus(404);
            $respuesta->getBody()->write(json_encode($array_retorno));
            return $respuesta;
        }

        $retornoSiguienteCall = (string)$handler->handle($peticion)->getBody();
        $respuesta->getBody()->write($retornoSiguienteCall);
        return $respuesta;

    }



}