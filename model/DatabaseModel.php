<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";


class DatabaseModel
{
    public function initializeDatabase(): array|string
    {
        try{
            Database::createTables();
            return Database::insertInitialData();
        }catch(Exception $e){
            return $e->getMessage();
        }

    }
}