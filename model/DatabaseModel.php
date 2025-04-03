<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../util/log_error.php";


class DatabaseModel
{
    public function initializeDatabase(): array|string
    {
        try{
            Database::createTables();
            return Database::insertInitialData();
        }catch(Exception $e){
            logError($e->getMessage());
            return $e->getMessage();
        }

    }
}