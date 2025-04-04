<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_sub_thread.php";
require_once __DIR__ . "/../util/log_error.php";

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
            logError($e->getMessage());
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
            logError($e->getMessage());
            return 0;
        }
    }

    public function deleteSubThread(int $sub_thread_id): int
    {
        try{
            $stmt = $this->db->prepare(DELETE_SUB_THREAD);
            $stmt->execute([":sub_thread_id" => $sub_thread_id]);
            return $stmt->rowCount();
        }catch (PDOException $e){
            logError($e->getMessage());
            return 0;
        }
    }

    public function countSubThreads(int $thread_id): int
    {
        try{
            $stmt = $this->db->prepare(GET_SUB_THREADS_BY_THREAD_ID);
            $stmt->execute([":thread_id" => $thread_id]);
            return $stmt->rowCount();
        }catch(PDOException $e){
            logError($e->getMessage());
            return -1;
        }
    }

    public function updateSubThread(int $sub_thread_id, string $content): int
    {
        try{
            $stmt = $this->db->prepare(GET_SUB_THREAD_BY_ID);
            $stmt->execute([":sub_thread_id" => $sub_thread_id]);
            $sub_thread = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$sub_thread) return 0;
            $stmt = $this->db->prepare(UPDATE_CONTENT_SUB_THREAD);
            $stmt->execute([":sub_thread_id" => $sub_thread_id, ":content" => $content]);
            return $stmt->rowCount();
        }catch (PDOException $e){
            logError($e->getMessage());
            return 0;
        }
    }
}