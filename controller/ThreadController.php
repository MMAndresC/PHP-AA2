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
}


if (basename($_SERVER['PHP_SELF']) === 'ThreadController.php') {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $action = $_POST["action-thread"] ?? null;

    if ($action == "add-thread") {
        $errors = array();
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
            $_SESSION['result'] = "Nuevo hilo añadido";
            header("Location: ../view/thread.php?pag=0&id-theme=" . $params["theme_id"]);
        }
        exit();
    }
}