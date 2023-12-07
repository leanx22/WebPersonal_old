<?php

use Firebase\JWT\JWT;

class Autentificadora
{

    private static array $encrypt = ['HS256']; 
    public static string $aud = '';

    public static function crearToken(object $datos_user, int $exp_segs):string
    {
        $hora = time();
       

        $payload = array(
            'iat'=>$hora,
            'exp'=>$hora + $exp_segs,
            'usuario'=>$datos_user,
        );
        $pass = Autentificadora::obtenerPass();
        
        if($pass == false)
        {
            return "Error";
        }

        return JWT::encode($payload, $pass);
    }

    public static function verificarToken(string $token):object
    {
        $datos_retorno = new stdClass();
        $datos_retorno->mensaje = "";
        $datos_retorno->exito = false;
        $pass = Autentificadora::obtenerPass();
       
        if($pass == false)
        {
            $datos_retorno->mensaje = "La clave de cifrado es incorrecta o invalida.";
            return $datos_retorno;
        }
        
        try
        {
            if(!isset($token))
            {
                $datos_retorno->mensaje = "No se recibio ningun token.";
            }
            else
            {
            
                $decode = JWT::decode(
                    $token,
                    $pass,
                    self::$encrypt
                );

                $datos_retorno->exito = true;
                $datos_retorno->mensaje = 'Token valido y OK';

            }

        }
        catch(Exception $e) 
        {
            $datos_retorno->mensaje = "Token NO valido";
        }

        return $datos_retorno;

    }

    public static function obtenerPayLoad(string $token) : object
    {
        $datos_retorno = new stdClass();
        $datos_retorno->exito = false;
        $datos_retorno->payload = NULL;
        $datos_retorno->mensaje = "";
        $pass = Autentificadora::obtenerPass();
       
        if($pass == false)
        {
            $datos_retorno->mensaje = "La clave de cifrado es incorrecta o invalida.";
            return $datos_retorno;
        }

        try {
            $payload_decode = JWT::decode(
                $token,
                $pass,
                self::$encrypt                               
            );

            $datos_retorno->payload = $payload_decode;
            $datos_retorno->exito = true;

        } catch (Exception $e) { 
            $datos_retorno->mensaje = $e->getMessage();
        }

        return $datos_retorno; 
    }

    public static function obtenerPass():string|false
    {
        return file_get_contents(__DIR__."/pass.txt");
    }
}