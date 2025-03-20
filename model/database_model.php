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
        $messages[] = array();
        // Intenta conectar a mySQL
        $test_connection = $this->conn->testConnection();

        //Devuelve el objeto por lo que si hay conexión con mySQL
        if ($test_connection instanceof \PDO) {
            $messages[] = "<p class='ok-form'>Connect to database</p>";

            $test_conn_db = $this->conn->connect();

            // Si devuelve objeto es que ha podido conectar a la base de datos forum
            if ($test_conn_db instanceof \PDO) {
                $messages[] =  "<p class='ok-form'>Connect to forum database</p>";
            } else {
                $messages[] = $test_conn_db;
                return $messages;
            }
        } else {
            $messages[] = $test_connection;
            return $messages;
        }
        return $messages;
    }
}