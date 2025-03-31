<?php

function extractParamsAuth($mode): array
{
    $params = array();
    $params["email"] = trim($_POST['email'] ?? '');
    $params["password"] = trim($_POST['password'] ?? '');
    if($mode != "login"){
        $params["confirm_password"] = trim($_POST['confirm_password'] ?? '');
        $params["username"] = trim($_POST['username'] ?? '');
        $params["name"] = trim($_POST['name'] ?? '');
        $params["surname"] = trim($_POST['surname'] ?? '');
    }
    return $params;
}

function extractParamsUser(): array
{
    $params = array();
    $params["email"] = trim($_POST['email'] ?? '');
    $params["password"] = trim($_POST['password'] ?? '');
    $params["new_password"] = trim($_POST['new_password'] ?? '');
    $params["username"] = trim($_POST['username'] ?? '');
    $params["name"] = trim($_POST['name'] ?? '');
    $params["surname"] = trim($_POST['surname'] ?? '');
    return $params;
}

function extractParamsThread(): array
{
    //Prepara params para thread y sub-thread
    $params = array();
    //Propios de thread
    $params["theme_id"] = trim($_POST['theme_id'] ?? '');
    $params["title"] = trim($_POST['title'] ?? '');
    $params["status"] = 'active';
    $params["last_updater"] = trim($_POST['author'] ?? '');
    //Propios de sub-thread, solo faltara thread_id
    $params["author"] = trim($_POST['author'] ?? '');
    $params["content"] = trim($_POST['content'] ?? '');
    $params["main"] = true;
    return $params;
}