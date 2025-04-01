<?php

require_once __DIR__ . '/../model/SubThreadModel.php';
require_once __DIR__ . '/../util/extract_params.php';
require_once __DIR__ . '/../util/validation.php';
class SubThreadController
{

    public static function getSubThreadsData(int $thread_id, int $limit, int $offset): array
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->getSubThreadsData($thread_id, $limit, $offset);
    }
    public static function addNewSubThread($subThread): int
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->addNewSubThread($subThread);
    }

    public static function deleteSubThread(int $subThread_id): int
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->deleteSubThread($subThread_id);
    }

    public static function countSubThreads(int $thread_id): int
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->countSubThreads($thread_id);
    }
}



if (session_status() === PHP_SESSION_NONE) {
session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action-sub-thread"] ?? null;
}else{
    $action = $_GET["action"] ?? null;
    if($action == "delete-sub-thread"){
        $sub_thread_id = isset($_GET["id-sub-thread"]) ? (int)$_GET["id-sub-thread"] : null;
        $thread_id = isset($_GET["id-thread"]) ? (int)$_GET["id-thread"] : null;
    }
}


$errors = array();
switch ($action) {
    case "add-sub-thread":
    {
        $params = extractParamsSubThread();
        $errors = validateValidSubThread($errors, $params);
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../view/sub_thread.php?pag=0&id-thread=" . $params["thread_id"] . "#new-sub-thread");
            exit();
        }
        $params['main'] = false;
        $row_count = SubThreadController::addNewSubThread($params);
        if ($row_count === 0) {
            $_SESSION["critical_error"] = "No se ha podido añadir el nuevo mensaje";
            header("Location: ../view/sub_thread.php?pag=0&id-thread=" . $params["thread_id"] . "#new-sub-thread");
        } else {
            $last_page = $_POST["last_page"] ?? 0;
            $_SESSION["result-sub-thread"] = "Nuevo mensaje añadido";
            header("Location: ../view/sub_thread.php?pag=" . $last_page . "&id-thread=" . $params["thread_id"]);
        }
        exit();
    }

 //TODO dialog de confirmacion
    case "delete-sub-thread": {
         $deleted_row_count = SubThreadController::deleteSubThread($sub_thread_id);
         if($deleted_row_count === 0) {
             $_SESSION['critical_error'] = "No se ha podido eliminar el mensaje";
         }else{
             $_SESSION['result-sub-thread'] = "Mensaje eliminado";
             $row_count = SubThreadController::countSubThreads($thread_id);
             //El thread ya no tiene ningún sub-thread por lo que hay que borrarlo
             if($row_count === 0) {
                 require_once "ThreadController.php";
                 $deleted_count = ThreadController::deleteThread($thread_id);
                 $theme_id = $_SESSION["theme_id"] ?? null;
                 if($theme_id !== null) header("Location: ../view/thread.php?pag=0&id-theme=" . $theme_id);
                 else header("Location: ../view/theme.php");
                 exit();
             }
         }
         header("Location: ../view/sub_thread.php?pag=0&id-thread=" . $thread_id);
         exit();
    }
}
