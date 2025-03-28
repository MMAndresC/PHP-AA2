<?php

require_once "../model/UserPanelModel.php";
require_once "../util/validation.php";
require_once "../util/extract_params.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario está logueado
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
        }
        $_SESSION["data"] = $data;
        $_SESSION['errors'] = $errors;
    }else if($_POST["action"] === "delete"){

    }
}

require_once "../view/user_panel.php";


