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

    public function getSubThreadsData(int $threadID, int $limit, int $offset): array
    {
        try{
            $stmt = $this->db->prepare(GET_SUB_THREADS_DATA);
            $stmt->execute([":thread_id" => $threadID]);
            $sub_threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['count'] = $stmt->rowCount();
            $response['sub_threads'] = array();
            $end = min($offset + $limit, count($sub_threads));
            for($i = $offset; $i < $end; $i++){
                $sub_thread = $sub_threads[$i];
                $response['sub_threads'][] = $sub_thread;
            }
            return $response;
        }catch(PDOException $e){
            return ["count" => 0, "threads" => []];
        }
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