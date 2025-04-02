<?php

require_once __DIR__ . "/../model/ThreadModel.php";
require_once __DIR__ . "/../util/extract_params.php";
require_once __DIR__ . "/../util/validation.php";

class ThreadController
{
    public static function getThreadsByTheme(int $theme_id, int $limit, int $offset): array
    {
        $threadModel = new ThreadModel();
        return $threadModel->getThreadsByTheme($theme_id, $limit, $offset);
    }

    public static function addNewThread(array $params): array
    {
        $threadModel = new ThreadModel();
        return $threadModel->addNewThread($params);
    }

    public static function deleteThread(int $thread_id): int
    {
        $threadModel = new ThreadModel();
        return $threadModel->deleteThread($thread_id);
    }

    public static function updateThread(array $params): bool
    {
        $threadModel = new ThreadModel();
        return $threadModel->updateThread($params);
    }

    public static function getTitleStatus(int $thread_id): array
    {
        $threadModel = new ThreadModel();
        return $threadModel->getTitleStatus($thread_id);
    }
}



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action-thread"] ?? null;
}else{
    $action = $_GET["action"] ?? null;
}

$errors = array();

switch ($action) {
    case "add-thread": {
        $params = extractParamsThread();
        $errors = validateValidThread($errors, $params);
        if ($errors) {
            $_SESSION['errors'] = $errors;
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["theme_id"] . "#new-thread");
            exit();
        }
        $params = ThreadController::addNewThread($params);
        if (empty($params)) {
            $_SESSION['error_critical'] = "Error al guardar el nuevo post";
            header("Location: ../index.php");
        } else {
            //No sacar el require de aquí, porque me carga el archivo y me la lía en otros puntos
            require_once __DIR__ . "/SubThreadController.php";
            //Se ha guardado en thread, guardar el mensaje en sub thread
            $row_count = SubThreadController::addNewSubThread($params);
            //TODO si devuelve 0 que hacemos?
            $_SESSION['result-thread'] = "Nuevo hilo añadido";
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["theme_id"]);
        }
        exit();
    }

    case "edit-thread": {
        $params = extractParamsEditThread();
        if(!isset($params["theme_id"]) || !isset($params["thread_id"])){
            $errors['edition'] = "No se encuentra el id del tema o el id de hilo";
            $_SESSION['errors'] = $errors;
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["old_theme_id"]);
            exit();
        }
        $updated = ThreadController::updateThread($params);
        if($updated){
            $_SESSION['result-thread'] = "Modificaciones guardadas";
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["theme_id"]);
        }else{
            $_SESSION['error_critical'] = "No se han podido guardar las modificaciones";
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["old_theme_id"]);
        }
        exit();
    }

    case "delete-thread": {
        $params = extractParamsDeleteThread();
        //Tendría que refactorizar el controller de user, ahora mismo es imposible usarlo para esto,
        //por eso uso directamente el modelo
        require_once __DIR__ . "/../model/UserPanelModel.php";
        $userModel = new UserPanelModel();
        $is_correct_password = $userModel->isCorrectPassword($params["email"], $params["password"]);
        if(!$is_correct_password){
            $_SESSION['error_critical'] = "Contraseña incorrecta";
            header("Location: ../view/thread.php?pag=" . $params['page'] . "&id-theme=" . $params["theme_id"]);
            exit();
        }
        $row_count = ThreadController::deleteThread($params["thread_id"]);
        if($row_count == 0){
            $_SESSION['error_critical'] = "No se ha podido eliminar el hilo";
        }else {
            $_SESSION['result-thread'] = "Eliminado el hilo " . $params["name"];
        }
        header("Location: ../view/thread.php?pag=" . $params['page'] . "&id-theme=" . $params["theme_id"]);
        exit();
    }
}
