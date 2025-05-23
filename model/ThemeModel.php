<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_theme.php";
require_once __DIR__ . "/../util/log_error.php";

class ThemeModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getThemes(): array
    {
        try{
            $stmt = $this->db->prepare(GET_ALL_THEMES);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            logError($e->getMessage());
            return [];
        }
    }

    public function getTheme(int $id)
    {
        try{
            $stmt = $this->db->prepare(GET_THEME_BY_ID);
            $stmt->execute([":id" => $id]);
            $theme = $stmt->fetch(PDO::FETCH_ASSOC);
            if($theme) return $theme;
            return [];
        }catch (PDOException $e){
            logError($e->getMessage());
            return [];
        }
    }
}