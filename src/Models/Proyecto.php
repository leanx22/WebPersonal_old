<?php

namespace App\Models;
require_once __DIR__.'/../Models/BBDD.php';

use App\Models\AccesoDatos;
use pdo;
use Twig\Node\Expression\Test\NullTest;





class Proyecto
{
    private int $id;
    private string $titulo;
    private string $desc; //nombre del archivo txt que contiene la descripcion.
    private string $link;
    private string $github;
    private string $foto;
    private bool $isActive;


    function __construct(bool $isActive,string $titulo, string $desc = null, string $github = null, string $link=null, string $foto=null, int $id=-1)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->desc = $desc;
        $this->link = $link;
        $this->github = $github;
        $this->foto = $foto;
        $this->isActive = $isActive;
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

    public function getLink():string
    {
        return $this->link;
    }

    public function getGitHub():string
    {
        return $this->github;
    }

    public function getPathFoto():string
    {
        return $this->foto;
    }

    public function getStatus():bool
    {
        return $this->isActive;
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
        $resultado = new Proyecto($obj["activo"],$obj["nombre"],$obj["descripcion"],$obj["github"],$obj["link"],$obj["path_foto"],$id);
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
            $proyecto = new Proyecto($obj["activo"],$obj["nombre"],$obj["descripcion"],$obj["github"],$obj["link"],$obj["path_foto"],$obj["id"]);;

            array_push($array_resultados,$proyecto);
        }

        return $array_resultados;
    }

    public function obtenerDescripcion():string
    {
        $retorno = "No hay descripcion disponible.";
        $path_files = __DIR__."/../extra/Descripciones_proyectos/";

        if($this->desc == null || file_get_contents($path_files.$this->desc) == false)
        {
            return $retorno;
        }

        $retorno = file_get_contents($path_files.$this->desc);
        return $retorno;
    }

}