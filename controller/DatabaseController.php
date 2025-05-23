<?php

namespace controller;

use DatabaseModel;

require_once __DIR__ . "/../model/DatabaseModel.php"; // Cargar el archivo de la clase


class DatabaseController
{
    public function dbConnect(): array|string
    {
        $database = new DatabaseModel();
        return $database->initializeDatabase();
    }
}