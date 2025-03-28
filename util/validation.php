<?php

function validateNotEmpty($params): array
{
    $errors = array();
    foreach ($params as $key => $value){
        if(empty($value)){
            $errors[$key] = $key . " is required";
        }
    }
    return $errors;
}

function validateValidDataAuth($errors, $params, $mode){
    $MIN_LEN = 3;
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

        if (strlen($params['name']) < $MIN_LEN)
            $errors['name'] = "El nombre debe tener al menos 3 caracteres";

        if (strlen($params['surname']) < $MIN_LEN)
            $errors['surname'] = "El apellido debe tener al menos 3 caracteres";

        if (strlen($params['username']) < $MIN_LEN)
            $errors['username'] = "El nombre de usuario debe tener al menos 3 caracteres";
    }
    return $errors;
}

function validateValidDataUser($errors, $params)
{
    $MIN_LEN = 3;

    $password = $params['password'];
    $new_password = $params['new_password'];
    if(trim($new_password) != ""){
        // Validar la contraseña (mínimo 8 caracteres, un número y un carácter especial)
        if (strlen($new_password) < 8 || !preg_match('/\d/', $new_password) || !preg_match('/\W/', $new_password)) {
            $errors['password'] = "La contraseña debe tener al menos 8 caracteres, un número y un carácter especial.";
        }

        if ($password !== $new_password)
            $errors['new_password'] = "Las contraseñas no coinciden";
    }

    if (strlen($params['name']) < $MIN_LEN)
        $errors['name'] = "El nombre debe tener al menos 3 caracteres";

    if (strlen($params['surname']) < $MIN_LEN)
        $errors['surname'] = "El apellido debe tener al menos 3 caracteres";

    if (strlen($params['username']) < $MIN_LEN)
        $errors['username'] = "El nombre de usuario debe tener al menos 3 caracteres";

    return $errors;
}