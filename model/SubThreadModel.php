<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once  __DIR__ . "/../config/db_queries_sub_thread.php";

class SubThreadModel
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    public function addNewSubThread(array $subThread): int
    {
        try{
            $stmt = $this->db->prepare(INSERT_SUB_THREAD);
            $stmt->execute([
                ":thread_id" => $subThread["thread_id"],
                ":author" => $subThread["author"],
                ":content" => $subThread["content"],
                ":main" => $subThread["main"]
            ]);
            return $stmt->rowCount();
        }catch (PDOException $e){
            return 0;
        }
    }
}