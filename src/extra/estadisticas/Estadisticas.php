<?php

namespace App\extra\estadisticas;

require_once __DIR__."/../../Models/BBDD.php";
use App\Models;
use App\Models\AccesoDatos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use PDO;
use stdClass;

class Estadisticas
{
    private int $v_generales;
    //private int $v_github;
    //private int $v_linkedin;
    //private int $v_cv;

    public function __construct()
    {
        $this->v_generales = self::obtenerVistasGenerales();
        //$this->v_github = $github;
        //$this->v_linkedin = $linkedin;
        //$this->v_cv = $cv;
    }

    public static function obtenerVistasGenerales():int
    {
        $bbdd = AccesoDatos::obtenerInstancia();

        $consulta = $bbdd->prepararConsulta(
            "SELECT `visitas_generales` FROM estadisticas"
        );
        $consulta->execute();

        $res_obj = $consulta->fetchObject();        

        return $res_obj['visitas_generales'];
    }

    public static function reiniciarVistasGenerales():bool
    {
        $bbdd = AccesoDatos::obtenerInstancia();

        $consulta = $bbdd->prepararConsulta(
            "UPDATE `estadisticas` SET `visitas_generales`= 0"
        );
        $consulta->execute();

        return $consulta->rowCount()==0 ? false:true;
    }

    public static function sumarVistaGeneral():bool
    {
        $vistas_generales = self::obtenerVistasGenerales();
        $vistas_generales++;

        $bbdd = AccesoDatos::obtenerInstancia();
        $consulta = $bbdd->prepararConsulta(
            "UPDATE `estadisticas` SET `visitas_generales`= :vistas"
        );
        $consulta->bindValue(":vistas", $vistas_generales, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->rowCount()==0 ? false:true;
    }

}