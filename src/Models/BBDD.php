<?php
namespace App\Models;

use pdo;
use PDOException;

class AccesoDatos
{
    private static AccesoDatos $instancia;
    private PDO $objetoPDO;
    const DB_NAME = "personal_bd";
    const DB_USER = "root";
    const DB_PASS = "";
    private function __construct()
    {
        try { 
            $this->objetoPDO = new PDO('mysql:host=localhost;dbname='.self::DB_NAME.';charset=utf8', self::DB_USER, self::DB_PASS, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
            } 
        catch (PDOException $e) { 
            print "Error!: " . $e->getMessage(); 
            die();
        }
    }
 
    public function prepararConsulta(string $sql)
    { 
        return $this->objetoPDO->prepare($sql); 
    }
    
    public function obtenerUltimoIdInsertado()
    { 
        return $this->objetoPDO->lastInsertId(); 
    }
 
    //Obtener la instancia singleton
    public static function obtenerInstancia()
    { 
        if (!isset(self::$instancia)) {          
            self::$instancia = new AccesoDatos(); 
        } 
        return self::$instancia;        
    }
 
}