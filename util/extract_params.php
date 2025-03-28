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