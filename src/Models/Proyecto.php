<?php

namespace App\Models;
use pdo;
use Twig\Node\Expression\Test\NullTest;

//require_once __DIR__.'/../Models/BBDD.php.php';



class Proyecto
{
    private int $id;
    private string $titulo;
    private string $desc;
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


}