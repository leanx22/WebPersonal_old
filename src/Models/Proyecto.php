<?php

namespace App\Models;
require_once __DIR__.'/../Models/BBDD.php';

use App\Models\AccesoDatos;
use pdo;





class Proyecto
{
    private int $id;
    private string $titulo;
    private string|null $link;
    private string|null $github;
    private string|null $foto;
    private bool $isActive;
    private int $vistas;

    function __construct(bool $isActive,string $titulo, string|null $github = null, string|null $link=null,string|null $foto=null, int $vistas=0,int $id=-1)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->link = $link;
        $this->github = $github;
        $this->foto = $foto;
        $this->isActive = $isActive;
        $this->vistas = $vistas;
    }

    #region GETS

    public function getID():int
    {
        return $this->id;
    }

    public function getTitulo():string
    {
        return $this->titulo;
    }

    public function getLink():string|null
    {
        return $this->link;
    }

    public function getGitHub():string|null
    {
        return $this->github;
    }

    public function getPathFoto():string|null
    {
        return $this->foto;
    }

    public function getStatus():bool
    {
        return $this->isActive;
    }

    public function getVistas()
    {
        return $this->vistas;
    }

    #endregion

    public static function obtenerProyectoPorID(int $id):string
    {
        $bbdd = AccesoDatos::obtenerInstancia();
        $consulta = $bbdd->prepararConsulta("SELECT * FROM proyectos WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->execute();

        //Validar que exista el ID!
        $obj = $consulta->fetch(PDO::FETCH_ASSOC);
        $resultado = new Proyecto($obj["activo"],$obj["nombre"],$obj["github"],$obj["link"],$obj["path_foto"],$obj["vistas"],$id);
        return json_encode($resultado);
    }

    public static function obtenerTodos():array
    {
        $array_resultados = array();
        $base = AccesoDatos::obtenerInstancia();
        $consulta = $base->prepararConsulta('SELECT * FROM proyectos');
        $consulta->execute();

        while($obj = $consulta->fetch(PDO::FETCH_ASSOC))
        {
            $proyecto = new Proyecto($obj["activo"],$obj["nombre"],$obj["github"],$obj["link"],$obj["path_foto"],$obj["vistas"],$obj["id"]);;

            array_push($array_resultados,$proyecto);
        }

        return $array_resultados;
    }

    public static function obtenerSoloActivos():array
    {
        $array_resultados = array();
        $base = AccesoDatos::obtenerInstancia();
        $consulta = $base->prepararConsulta('SELECT * FROM proyectos WHERE activo = 1');
        $consulta->execute();

        while($obj = $consulta->fetch(PDO::FETCH_ASSOC))
        {
            $proyecto = new Proyecto($obj["activo"],$obj["nombre"],$obj["github"],$obj["link"],$obj["path_foto"],$obj["vistas"],$obj["id"]);;

            array_push($array_resultados,$proyecto);
        }

        return $array_resultados;
    }

    public function obtenerDescripcion():string
    {
        $retorno = "No hay descripcion disponible.";
        $path_files = __DIR__."/../extra/Descripciones_proyectos/descripciones.json";

        if(file_get_contents($path_files) == false)//muestra warning si no existe
        {
            return $retorno;
        }

        $lectura = file_get_contents($path_files);
        $array_descs = json_decode($lectura,true);
        
        foreach($array_descs as $descripcion)
        {
            if($descripcion["id"] == $this->id)
            {
                $retorno = $descripcion["desc"];
                break;
            }
        }
        return $retorno;
    }

}