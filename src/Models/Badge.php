<?php

namespace App\Models;
require_once __DIR__.'/../Models/BBDD.php';

use App\Models\AccesoDatos;
use pdo;


class Badge
{
    private int $id;
    private int $id_proyecto;
    private string $texto;
    private string $color;


    public function __construct(int $id_proyecto, string $texto, string $color = 'warning', int $id = 0)
    {
        $this->id = $id;
        $this->id_proyecto = $id_proyecto;
        $this->texto = $texto;
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function getIDproyecto()
    {
        return $this->id_proyecto;
    }

    public function getID()
    {
        return $this->id;
    }

    //Obtiene lista de badges desde la BBDD
    public static function obtenerTodas():array
    {
        $array_resultados = array();
        $base = AccesoDatos::obtenerInstancia();
        $consulta = $base->prepararConsulta('SELECT * FROM proj_badges');
        $consulta->execute();

        while($obj = $consulta->fetch(PDO::FETCH_ASSOC))
        {
            $badge = new Badge($obj["id_proyecto"],$obj["texto"],$obj["color"],$obj["id_badge"]);

            array_push($array_resultados,$badge);
        }

        return $array_resultados;        
    }

    //obtiene las badges correspondientes al proyecto cuyo ID es pasado por parametro haciendo uso de la BBDD
    public static function obtenerDelProyectoBBDD(int $id_proyecto):array
    {
        $array_resultados = array();
        $base = AccesoDatos::obtenerInstancia();
        $consulta = $base->prepararConsulta('SELECT * FROM proj_badges WHERE id_proyecto = :id');
        $consulta->bindValue(':id',$id_proyecto, PDO::PARAM_INT);
        $consulta->execute();

        while($obj = $consulta->fetch(PDO::FETCH_ASSOC))
        {
            $badge = new Badge($obj["id_proyecto"],$obj["texto"],$obj["color"],$obj["id_badge"]);

            array_push($array_resultados,$badge);
        }

        return $array_resultados;     
    }

    //obtiene las badges pasadas por parametro correspondientes al ID del proyecto otorgado.
    public static function obtenerDelProyecto(int $id_proyecto, array $lista_badges):array
    {
        $array_resultados = array();
        
        foreach ($lista_badges as $badge) {
            if($badge->getIDproyecto() == $id_proyecto)
            {
                array_push($array_resultados,$badge);
            }
        }

        return $array_resultados;     
    }

    public static function crearNueva()
    {
        
    }

    public static function eliminar(int $id)
    {

    }

    
}