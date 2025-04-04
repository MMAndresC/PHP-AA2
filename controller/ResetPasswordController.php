<?php

require_once __DIR__ . "/../model/ResetPasswordModel.php";

//Vaciar sesión
require_once __DIR__ . "/../util/unset_session.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = array();
$token = trim($_POST['token']) ?? '';
$email = trim($_POST['email']) ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';


//Formulario para enviar mail para resetear la contraseña
if(trim($token) == ''){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email no válido";
    }
//Formulario para recoger la nueva contraseña
}else{
    if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/\W/', $password)) {
        $errors['password'] = "La contraseña debe tener al menos 8 caracteres, un número y un carácter especial.";
    }

    if ($password !== $confirm_password)
        $errors['confirm_password'] = "Las contraseñas no coinciden";
}

// Volver a la vista porque hay errores
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../view/reset_password.php?token=$token");
    exit();
}

$resetPasswordModel = new ResetPasswordModel();

if(trim($token) == ''){
    $response = $resetPasswordModel->sendMailToResetPassword($email);
    if(isset($response['token'])){
       require_once __DIR__ . "/../email/Email.php";
       $_SESSION['response'] = Email::sendResetPasswordEmail($email, $response['token']);
    }else{
        $_SESSION['response'] = $response['error'];
    }
    header("Location: ../view/reset_password.php");
}else{
    $_SESSION['message'] = $resetPasswordModel->resetPassword($token, $password);
    header("Location: ../view/login.php?mode=login");
}

exit();

