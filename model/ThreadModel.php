<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once  __DIR__ . "/../config/db_queries_thread.php";
require_once __DIR__ . "/../model/ThreadModel.php";
class ThreadModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getThreadsByTheme(int $theme_id, int $limit, int $offset): array
    {
        try{
            $stmt = $this->db->prepare(GET_THREAD_BY_THEME);
            $stmt->execute([":theme_id" => $theme_id]);
            $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['count'] = $stmt->rowCount();
            $response['threads'] = array();
            $end = min($offset + $limit, count($threads));
            for($i = $offset; $i < $end; $i++){
                $thread = $threads[$i];
                $response['threads'][] = $thread;
            }
            return $response;
        }catch(PDOException $e){
            return ["count" => 0, "threads" => []];
        }

    }
}