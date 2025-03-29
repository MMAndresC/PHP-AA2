<?php

namespace database;

use Exception;
use PDO;
use PDOException;
use seed\Seeder;

require_once __DIR__ . "/db_connection.php";
require_once __DIR__ . "/db_queries.php";

class Database
{
    private static PDO $connection;

    private function __construct() {} // Evitar instancias directas
    public static function connect(): PDO
    {
        if (!isset(self::$connection)) {
            try {
                // Instanciar objeto PDO
                self::$connection = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // para acceder con $fila['username'] en vez de $fila[0], nombre de columna en vez de indice
                ]);

                //Crear la base de datos si no existe
                self::$connection->exec(CREATE_DATABASE);

                //Entrar en la base de datos forum
                self::$connection->exec("USE " . DB_NAME);

            } catch (PDOException $e) {
                throw new Exception("Error to connect to DB: " . $e->getMessage());
            }
        }
        return self::$connection;
    }


    public static function createTables(): void
    {
        try{
            require_once __DIR__ . "/../config/db_queries.php";
            //Obtener la conexión a la base de datos
            $connection = self::connect();
            //Crear todas las tablas en orden de dependencia
            $connection->exec(CREATE_TABLE_USERS);
            $connection->exec(CREATE_TABLE_THEMES);
            $connection->exec(CREATE_TABLE_THREADS);
            $connection->exec(CREATE_TABLE_SUB_THREADS);
        }catch(PDOException|Exception $e){
            throw new Exception("Error to create tables: " . $e->getMessage());
        }
    }

    public static function insertInitialData(): array
    {
        try {
            require_once "seed/Seeder.php";
            $connection = self::connect();
            return Seeder::loadSeed($connection);
        } catch (PDOException|Exception $e) {
            throw new Exception("Error loading seed: " . $e->getMessage());
        }
    }



}