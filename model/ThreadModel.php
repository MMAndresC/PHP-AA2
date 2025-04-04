<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_thread.php";
require_once __DIR__ . "/../util/log_error.php";
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
            logError($e->getMessage());
            return ["count" => 0, "threads" => []];
        }
    }

    public function addNewThread(array $thread): array
    {
        try{
            $stmt = $this->db->prepare(INSERT_THREAD);
            $stmt->execute([
                ":theme_id" => $thread["theme_id"],
                ":title" => $thread["title"],
                ":status" => $thread["status"],
                ":last_updater" => $thread["last_updater"],
                "created_by" => $thread["last_updater"]
            ]);
            $success = $stmt->rowCount() > 0;
            if($success){
                $thread['thread_id'] = $this->db->lastInsertId();
                return $thread;
            }else return [];
        }catch(PDOException $e){
            logError($e->getMessage());
            return [];
        }
    }

    public function deleteThread(int $thread_id): int
    {
        try{
            $stmt = $this->db->prepare(DELETE_THREAD);
            $stmt->execute([":thread_id" => $thread_id]);
            return $stmt->rowCount();
        }catch(PDOException $e){
            logError($e->getMessage());
            return 0;
        }
    }

    public function updateThread(array $params): bool
    {
        try{
            $thread_id = $params["thread_id"];
            $stmt = $this->db->prepare(GET_THREAD_BY_ID);
            $stmt->execute([":thread_id" => $thread_id]);
            $thread = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!isset($thread)) return false;
            //Modificar el objeto devuelto con los datos nuevos
            $changed_status = '';
            foreach ($params as $key => $value) {
                if($key == "status" && $value == "closed"){
                    $changed_status = " (Closed)";
                }
                if($key == "theme_id" && $value != $thread["theme_id"] && $thread["status"] != "closed"){
                    $thread["status"] = "moved";
                    $changed_status = " (Moved)";
                }
                $thread[$key] = $value;
            }
            $thread["title"] = $thread["title"] . $changed_status;
            $stmt = $this->db->prepare(UPDATE_THREAD);
            $stmt->execute([
                ":thread_id" => $thread_id,
                ":title" => $thread["title"],
                ":status" => $thread["status"],
                ":last_updater" => $thread["last_updater"],
                ":theme_id" => $thread["theme_id"]
            ]);
            return $stmt->rowCount() > 0;
        }catch (PDOException $e){
            logError($e->getMessage());
            return false;
        }
    }

    public function getTitleStatus(int $thread_id): array
    {
        try{
            $stmt = $this->db->prepare(GET_TITLE_STATUS);
            $stmt->execute([":thread_id" => $thread_id]);
            $thread = $stmt->fetch(PDO::FETCH_ASSOC);
            $title = $thread["title"] ?? '';
            $status = $thread["status"] ?? 'active';
            return ["title" => $title, "status" => $status];
        }catch (PDOException $e){
            logError($e->getMessage());
            return [];
        }
    }
}