<?php

namespace model;

require_once "model/connection/connection.php";

use connection\Connection;

class DatabaseModel
{
    private $conn;

    public function __construct(){
        $this->conn = new Connection();
    }
    public function initializeDatabase(){
        $messages = array();
        // Intenta conectar a mySQL
        $test_connection = $this->conn->testConnection();

        //Devuelve el objeto por lo que si hay conexión con mySQL
        if ($test_connection instanceof \PDO) {
            $messages[] = "<p class='ok-form'>Connect to database</p>";

            // Intentar conectar a la base de datos forum
            $test_conn_db = $this->conn->connect();

            // Si devuelve objeto es que ha podido conectar a la base de datos forum
            if ($test_conn_db instanceof \PDO) {
                $messages[] =  "<p class='ok-form'>Connect to forum database</p>";
                $db = $this->conn->createTables($test_conn_db);
            // No ha podido conectar por lo que intenta crear la base de datos forum
            } else {
                //Intenta crear la base de datos forum
                $db = $this->conn->createDatabase($test_connection);

                //Base de datos forum creada
                if($db instanceof \PDO){
                    $messages[] =  "<p class='ok-form'>Create forum database</p>";
                    $db = $this->conn->createTables($db);
                // No ha podido crearla por lo que no se puede hacer nada más, SALIR
                }else{
                    $messages[] = $test_connection;
                    return $messages;
                }
            }
        // No hay conexión con mySQL no se puede hacer nada más, SALIR
        } else {
            $messages[] = $test_connection;
        }
        return $messages;
    }


}