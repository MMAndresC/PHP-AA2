<?php

namespace controller;

use DatabaseModel;

require_once "model/DatabaseModel.php"; // Cargar el archivo de la clase


class DatabaseController
{
    public function __construct() {}

    public function dbConnect()
    {
        $database = new DatabaseModel();
        return $database->start();
    }
}