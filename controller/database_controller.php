<?php

namespace controller;

require_once "model/database_model.php"; // Cargar el archivo de la clase

use model\DatabaseModel;
class DatabaseController
{
    public function __construct() {}

    public function dbConnect()
    {
        $database = new DatabaseModel();
        return $database->initializeDatabase();
    }
}