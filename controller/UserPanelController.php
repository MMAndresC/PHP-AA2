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
        $params = extractParamsUser();
        $errors = array();
        $errors = validateValidDataUser($errors, $params);
        if (empty($errors)) {
             $errors = $userPanelModel->modifyUser($params);
        }
        $_SESSION["data"] = $params;
        $_SESSION['errors'] = $errors;
    }else if($_POST["action"] === "delete"){

    }
}

require_once "../view/user_panel.php";


