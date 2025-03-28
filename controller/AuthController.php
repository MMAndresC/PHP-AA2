<?php

session_start();

require_once "../model/AuthModel.php";
require_once "../util/validation.php";
require_once "../util/extract_params.php";


function existErrors($errors, $old_data, $mode): void
{
     $_SESSION['old_data'] = $old_data;
    if (!empty($errors)) {
         $_SESSION['errors'] = $errors;
         header("Location: ../view/login.php?mode=$mode");
         exit();
    }
}

// Obtener los datos del formulario
$mode = $_POST['mode'] ?? 'login';
$params = extractParamsAuth($mode);

// Validar que los campos no estén vacíos
$errors = validateNotEmpty($params);
$old_data = $params;

// Volver a la vista si ya hay algún error
existErrors($errors, $old_data, $mode);

//Validar que el mail y contraseña sean válidos y que el resto de campos tengan una longitud minima
$errors = validateValidDataAuth($errors, $params, $mode);

// Volver a la vista si ya hay algún error
existErrors($errors, $old_data, $mode);

// Validaciones hechas, pasar al modelo
$userModel = new AuthModel();

if ($mode === 'login') {
    $user = $userModel->login($params['email'], $params['password']);
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: ../view/main.php");
    } else {
        $_SESSION['errors']['password'] = "Email o contraseña incorrectos.";
        $_SESSION['old_data'] = $old_data;
        header("Location: ../view/login.php?mode=login");
    }
} else {
    $response = $userModel->register($params['email'], $params['password'], $params['username'],  $params['name'], $params['surname']);
    if ($response['registerSuccess']) {
        $params['token'] = $response['token'];
        $_SESSION['message'] = "Bienvenido " . $params['username'] . "! Recibirás un mail para confirmar tu cuenta.";
        require_once "../email/Email.php";
        $result = Email::sendVerificationEmail($params);
        $_SESSION['mail'] = $result;
        header("Location: ../view/login.php?mode=login");
    } else {
        $_SESSION['errors']['email'] = "Ya existe un usuario con ese email";
        $_SESSION['old_data'] = $old_data;
        header("Location: ../view/login.php?mode=register");
    }
}
exit();

