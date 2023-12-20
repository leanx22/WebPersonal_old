<?php

namespace App\Models;

require_once __DIR__."../../extra/JWT/jwt.php";

use Autentificadora;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use PDO;
use stdClass;

class Usuario
{
    private string $usuario;
    private string $clave;
    private string $perfil;

    public function __construct(string $usuario, string $clave, string $perfil)
    {
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->perfil = $perfil;
    }

    public function getUser()
    {
        return $this->usuario;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    public static function obtenerUsuarioDesdeBBDD(array $data):object
    {
        $accesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $accesoDatos->prepararConsulta(
            "SELECT * FROM usuarios
             WHERE usuario = :usuario AND clave = :clave"
        );
        $consulta->bindValue(":usuario", $data['usuario'], PDO::PARAM_STR);
        $consulta->bindValue(":clave", $data['clave'], PDO::PARAM_STR);
        $consulta->execute();

        $user_data = $consulta->fetchObject();        
        if($user_data == false)
        {
            $user_data = new stdClass();
            $user_data->exito = false;
            return $user_data;
        }

        $user_data->exito = true;
        return $user_data;
    }

    public static function login(Request $peticion, Response $respuesta):Response
    {
        $datos = $peticion->getParsedBody();
        $exito = false;
        $token = "";
        $status = 403;
        $mensaje = "Ocurrio un error...";

        //Intento obtener los datos del usuario con las credenciales dadas
        $user_data = self::obtenerUsuarioDesdeBBDD($datos);
        unset($user_data->exito);
        unset($user_data->clave); //quito la clave de los datos
        $token = Autentificadora::crearToken($user_data,1800);
        $exito = true;
        $status = 200;
        $mensaje = "Iniciando sesion...";
        $array_retorno = array(
            "exito"=>$exito,
            "mensaje"=>$mensaje,
            "token" => $token,
            "status" => $status
        );

        $respuesta->getBody()->write(json_encode($array_retorno));
        return $respuesta;
    }

}