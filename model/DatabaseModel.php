<?php

require_once "connection/Connection.php";

use connection\Connection;
use seed\Seeder;

class DatabaseModel
{
    private $conn;

    public function __construct(){
        $this->conn = new Connection();
    }

    public function start(){
        //Si la respuesta es un array de cadenas es que no se ha podido inicializar la base de datos, SALIR
        $response = $this->initializeDatabase();
        if(!$response instanceof \PDO){
            return $response;
        }
        //la base de datos forum existe, crear todas las tablas
        $response = $this->conn->createTables($response);
        if($response instanceof \PDO){
            require_once "seed/Seeder.php";
            $seeder = new Seeder();
            return $seeder->loadSeed($response);
        }
        return $response;
    }
    private function initializeDatabase(){
        $messages = array();
        // Intenta conectar a mySQL
        $connection = $this->conn->testConnection();

        // No hay conexión con mySQL no se puede continuar, SALIR
        if (!$connection instanceof \PDO) {
            $messages[] = $connection;
            return $messages;
        }

        //Devuelve el objeto por lo que si hay conexión con mySQL
        $messages[] = "<p class='ok-form'>Connected to mySQL</p>";

        // Intenta cambiar a la base de datos forum
        $connection = $this->conn->changeDatabase($connection);

        // La base de datos forum existe
        if ($connection instanceof \PDO)
            return $connection;

        // No existe por lo que intenta crear la base de datos forum
        $connection = $this->conn->createDatabase();

        //Creada con éxito
        if ($connection instanceof \PDO)
            return $connection;
        //No lo ha podido crear, SALIR
        else {
            $messages[] = $connection;
            return $messages;
        }
    }


}