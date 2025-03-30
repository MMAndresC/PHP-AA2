<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once  __DIR__ . "/../config/db_queries_theme.php";

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
            return [];
        }
    }

    public function getTheme(int $id): ?array
    {
        try{
            $stmt = $this->db->prepare(GET_THEME_BY_ID);
            $stmt->execute([":id" => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            return null;
        }
    }
}