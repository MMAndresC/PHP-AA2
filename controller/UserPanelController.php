<?php

require_once __DIR__ . "/../model/UserPanelModel.php";
require_once __DIR__ . "/../util/validation.php";
require_once __DIR__ . "/../util/extract_params.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION["user"];
$email = $user["email"];
$userPanelModel = new UserPanelModel();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['data'] = $userPanelModel->getUserByEmail($email);
    require_once __DIR__ . "/../view/user_panel.php";
}

if (isset($_POST["action"])) {
    if ($_POST["action"] === "edit"){
        $data = extractParamsUser();
        $errors = array();
        $errors = validateValidDataUser($errors, $data);
        if (empty($errors)) {
             $response = $userPanelModel->modifyUser($data);
             $critical = $response["critical"] ?? null;
             if(isset($critical)){
                 require_once __DIR__ . "/../util/destroy_session.php";
                 header("Location: ../index.php");
                 exit();
             }
             if(isset($response["errors"])) $errors = $response["errors"];
             if(isset($response["data"])) $data = $response["data"];
             if(isset($response["success"]) && $response["success"]) $_SESSION["success"] = true;
        }

        $_SESSION["data"] = $data;
        $_SESSION['errors'] = $errors;

    }else if($_POST["action"] === "delete"){
        $email_delete = $_POST["email_delete"] ?? null;
        // Si no coincide el mail que viene en el formulario con el guardado de la sesión se termina,
        // no dejamos que se borre un usuario que no haya iniciado sesión
        if($email === $email_delete) {
            $password_delete = $_POST["password_delete"] ?? null;
            $delete_content = $_POST["content_delete"] ?? false;
            $response = 0;
            if($email_delete !== null && $password_delete !== null){
                $response = $userPanelModel->deleteUser($email_delete, $password_delete, $delete_content);
            }
            if($response === 0){
                $_SESSION["failed_delete"] = true;
            }else{
                //Barrido para borrar los thread que se hayan quedado sin sub-thread
                require_once __DIR__ . "/ThreadController.php";
                ThreadController::deleteEmptyThreads();
                //Borra la sesión
                require_once __DIR__ . "/../util/destroy_session.php";
                header("Location: ../view/theme.php");
                exit();
            }
        }else  $_SESSION["failed_delete"] = true;
    }
}

require_once __DIR__ . "/../view/user_panel.php";


