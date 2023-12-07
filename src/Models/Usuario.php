<?php

namespace App\Models;
use PDO;
use stdClass;

class Usuario
{
    private string $usuario;
    private string $clave;
    private string $perfil;

    public function __construct(string $usuario, string $clave)
    {
        $this->usuario = $usuario;
        $this->clave = $clave;
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

        $user_data = $consulta->fetchObject('Usuario');
        $user_data->exito = true;
        
        if($user_data == false)
        {
            $user_data = new stdClass();
            $user_data->exito = false;
        }

        return $user_data;
    }

}