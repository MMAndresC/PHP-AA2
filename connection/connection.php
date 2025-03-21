<?php

namespace connection;

use PDO;
use PDOException;

class Connection
{
    public function connect(){
        try{
            if(file_exists("connection/db_connection.php")){
                require_once "connection/db_connection.php";
                // Instanciar objeto PDO
                $connection = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
                //Asignación de atributos para detección de errores.
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Codificación para evitar símbolos en carácteres especiales.
                $connection->exec("SET CHARACTER SET utf8");
                return $connection;
            }else
                return "<p class='warning-form'>Info to connect to DB not found</p>";
        }catch(PDOException $e){
            return $this->getErrorMessages($e->getMessage());
        }
    }

    public function testConnection(){
        try{
            require_once "connection/db_connection.php";
            return new PDO("mysql:host=".DB_HOST,DB_USER,DB_PASS);
        }catch(PDOException $e){
            return $this->getErrorMessages($e->getMessage());
        }

    }

    public function createDatabase(){
        try{
            require_once "connection/db_queries.php";
            $connection = $this->testConnection();
            $connection->exec(CREATE_DATABASE);
            //Asignación de atributos para detección de errores.
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Codificación para evitar símbolos en carácteres especiales.
            $connection->exec("SET CHARACTER SET utf8");
            return $connection;
        }catch(PDOException $e){
            return $this->getErrorMessages($e->getMessage());
        }
    }

    public function createTables($connection){
        try{
            require_once "connection/db_queries.php";
            //Entrar en la base de datos forum
            $connection->exec("USE " . DB_NAME);
            //Crear todas las tablas en orden de dependencia
            $connection->exec(CREATE_TABLE_USERS);
            $connection->exec(CREATE_TABLE_THEMES);
            $connection->exec(CREATE_TABLE_TOPICS);
            $connection->exec(CREATE_TABLE_THREADS);
            $connection->exec(CREATE_TABLE_SUB_THREADS);
            return $connection;
        }catch(PDOException $e){
            return $this->getErrorMessages($e->getMessage());
        }
    }

    public function changeDatabase($connection){
        try{
            require_once "connection/db_connection.php";
            //Entrar en la base de datos forum
            $connection->exec("USE " . DB_NAME);
            //Asignación de atributos para detección de errores.
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Codificación para evitar símbolos en carácteres especiales.
            $connection->exec("SET CHARACTER SET utf8");
            return $connection;
        }catch (PDOException $e){
            return $this->getErrorMessages($e->getMessage());
        }
    }

    private function getErrorMessages($e){
        switch($e){
            case "2002":
                if(file_exists("connection/db_connection.php")){
                    return "<p class='error-form'>Error to connect, incorrect host: (" . $e.")</p>";
                }else{
                    return "<p class='warning-form'>Info to connect to DB not found</p>";
                }

            case "1049":
                return "<p class='error-form'>Error to connect, DB not foundt: (" . $e.")</p>";

            case "1045":
            case "42000":
                return "<p class='error-form'>Error to connect, user/password not found (" . $e.")</p>";

            case "42S02":
                return "<p class='error-form'>Table not found in DB (" . $e.")</p>";

            case "23000":
                return "<p class='error-form'>User already exists. Try another alias (" . $e.")</p>";

            default:
                return "<p class='error-form'>Error to connect, unexpected error ".$e."</p>";
        }
    }

}