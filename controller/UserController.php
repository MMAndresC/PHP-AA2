<?php

session_start();
require_once "../model/UserModel.php";

function extractParams($mode){
    $params = array();
    $params["email"] = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $params["password"] = trim(isset($_POST['password']) ? $_POST['password'] : '');
    if($mode != "login"){
        $params["confirm_password"] = trim(isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '');
        $params["username"] = trim(isset($_POST['username']) ? $_POST['username'] : '');
        $params["name"] = trim(isset($_POST['name']) ? $_POST['name'] : '');
        $params["surname"] = trim(isset($_POST['surname']) ? $_POST['surname'] : '');
    }
    return $params;
}

function validateNotEmpty($params){
    $errors = array();
    foreach ($params as $key => $value){
        if(empty($value)){
            $errors[$key] = $key . " is required";
        }
    }
    return $errors;
}

function existErrors($errors, $old_data, $mode){
     $_SESSION['old_data'] = $old_data;
    if (!empty($errors)) {
         $_SESSION['errors'] = $errors;
         header("Location: ../view/login.php?mode=$mode");
         exit();
    }
}

// Obtener los datos del formulario
$mode = isset($_POST['mode']) ? $_POST['mode'] : 'login';
$params = extractParams($mode);

// Validar que los campos no estén vacíos
$errors = validateNotEmpty($params);
$old_data = $params;

// Volver a la vista si ya hay algún error
existErrors($errors, $old_data, $mode);

// Validar email
if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Email no válido";
}

// En el registro validar el resto de campos
if($mode != "login") {
    // Validar la contraseña (mínimo 8 caracteres, un número y un carácter especial)
    if (strlen($params['password']) < 8 || !preg_match('/\d/', $params['password']) || !preg_match('/\W/', $params['password'])) {
        $errors['password'] = "La contraseña debe tener al menos 8 caracteres, un número y un carácter especial.";
    }

    if ($params['password'] !== $params['confirm_password'])
        $errors['confirm_password'] = "Las contraseñas no coinciden";

    if (strlen($params['name']) < 3)
        $errors['name'] = "El nombre debe tener al menos 3 caracteres";

    if (strlen($params['surname']) < 3)
        $errors['surname'] = "El apellido debe tener al menos 3 caracteres";

    if (strlen($params['username']) < 3)
        $errors['username'] = "El nombre de usuario debe tener al menos 3 caracteres";

}

// Volver a la vista si ya hay algún error
existErrors($errors, $old_data, $mode);

// Validaciones hechas pasar al modelo
$userModel = new UserModel();

if ($mode === 'login') {
    $user = $userModel->login($params['email'], $params['password']);
    if ($user) {
        $_SESSION['user'] = $user;
        //TODO mandarlo al foro principal
        //header("Location: ../view/dashboard.php");
    } else {
        $_SESSION['errors']['password'] = "Email o contraseña incorrectos.";
        $_SESSION['old_data'] = $old_data;
        header("Location: ../view/login.php?mode=login");
    }
} else {
    $registerSuccess = $userModel->register($params['email'], $params['password'], $params['username'],  $params['name'], $params['surname']);
    if ($registerSuccess) {
        $_SESSION['message'] = "Bienvenido " . $params['username'] . "! Logueate con tun mail para empezar!";
        header("Location: ../view/login.php?mode=login");
    } else {
        $_SESSION['errors']['email'] = "Ya existe un usuario con ese email";
        $_SESSION['old_data'] = $old_data;
        header("Location: ../view/login.php?mode=register");
    }
}
exit();

