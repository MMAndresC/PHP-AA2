<?php

require_once "../model/UserPanelModel.php";
require_once "../util/validation.php";
require_once "../util/extract_params.php";

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
    require_once "../view/user_panel.php";
}

if (isset($_POST["action"])) {
    if ($_POST["action"] === "edit"){
        $data = extractParamsUser();
        $errors = array();
        $errors = validateValidDataUser($errors, $data);
        if (empty($errors)) {
             $response = $userPanelModel->modifyUser($data);
             if(isset($response["errors"])) $errors = $response["errors"];
             if(isset($response["data"])) $data = $response["data"];
             if(isset($response["success"])) $_SESSION["success"] = true;
        }
        $_SESSION["data"] = $data;
        $_SESSION['errors'] = $errors;
    }else if($_POST["action"] === "delete"){
        $email_delete = $_POST["email_delete"] ?? null;
        // Si no coincide el mail que viene en el formulario con el guardado de la sesión se termina,
        // no dejamos que se borre un usuario que no haya iniciado sesión
        if($email === $email_delete) {
            $password_delete = $_POST["password_delete"] ?? null;
            $deleteContent = $_POST["content_delete"] ?? false;
            $response = 0;
            if($email_delete !== null && $password_delete !== null){
                $response = $userPanelModel->deleteUser($email_delete, $password_delete, $deleteContent);
            }
            if($response === 0){
                $_SESSION["failed_delete"] = true;
            }else{
                require_once "../util/destroy_session.php";
                header("Location: ../view/main.php");
                exit();
            }
        }else  $_SESSION["failed_delete"] = true;
    }
}

require_once "../view/user_panel.php";


