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
    $LOCKED_USERNAME = 'anónimo';
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
        if(strtolower($params['username']) === $LOCKED_USERNAME){
            $errors['username'] = "Nombre de usuario no disponible";
        }

        if(!$params['use-terms'])
            $errors['use-terms'] = "Tienes que aceptar los condiciones de uso para el registro";
    }
    return $errors;
}

function validateValidDataUser($errors, $params)
{
    $MIN_LEN = 3;
    $MAX_LEN = 30;
    $MAX_LEN_USERNAME = 15;

    $new_password = $params['new_password'];
    if(trim($new_password) != ""){
        // Validar la contraseña (mínimo 8 caracteres, un número y un carácter especial)
        if (strlen($new_password) < 8 || !preg_match('/\d/', $new_password) || !preg_match('/\W/', $new_password)) {
            $errors['password'] = "La contraseña debe tener al menos 8 caracteres, un número y un carácter especial.";
        }
    }

    if (strlen($params['name']) < $MIN_LEN || strlen($params['name']) > $MAX_LEN)
        $errors['name'] = "El nombre debe tener al menos " . $MIN_LEN . " caracteres y máximo " . $MAX_LEN;

    if (strlen($params['surname']) < $MIN_LEN || strlen($params['surname']) > $MAX_LEN)
        $errors['surname'] = "El apellido debe tener al menos " . $MIN_LEN . " caracteres y máximo " . $MAX_LEN;

    if (strlen($params['username']) < $MIN_LEN || strlen($params['username']) > $MAX_LEN_USERNAME)
        $errors['username'] = "El nombre de usuario debe tener al menos " . $MIN_LEN . " caracteres y máximo " . $MAX_LEN_USERNAME;

    return $errors;
}

function validateValidThread($errors, $params) {
    $MIN_LEN_TITLE = 5;
    $MAX_LEN_TITLE = 50;
    $MIN_LEN_CONTENT = 5;

    if(trim($params['author']) == '' || trim($params['last_updater']) == '')
        $errors['author'] = "Autor desconocido";

    if(strlen(trim($params['title'])) < $MIN_LEN_TITLE || strlen(trim($params['title'])) > $MAX_LEN_TITLE)
        $errors['title'] = "Titulo del nuevo post obligatorio y no menor de " . $MIN_LEN_TITLE . " ni superior a" . $MAX_LEN_TITLE . "caracteres";

    if(strlen(trim($params['content'])) < $MIN_LEN_CONTENT)
        $errors['content'] = "El mensaje no puede tener menos de  " . $MIN_LEN_CONTENT . " caracteres";

    return $errors;
}

function validateValidSubThread($errors, $params) {
    $MIN_LEN_CONTENT = 5;

    if(trim($params['author']) == '')
        $errors['author'] = "Autor desconocido";

    if(strlen(trim($params['content'])) < $MIN_LEN_CONTENT)
        $errors['content'] = "El mensaje no puede tener menos de  " . $MIN_LEN_CONTENT . " caracteres";

    return $errors;
}