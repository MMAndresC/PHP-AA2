<?php

use database\Database;

require_once "../config/Database.php";
require_once  "../config/db_queries.php";

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare(FIND_EMAIL_VERIFIED_USER);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Quitar los datos sensibles del usuario antes de devolverlo
            unset($user['password'], $user['name'], $user['surname']);
            return $user;
        }
        return false;
    }

    public function register($email, $password, $username, $name, $surname): array
    {
        // Verificar si el email ya existe
        $stmt = $this->db->prepare(FIND_EMAIL_USER);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        if ($stmt->fetch()) {
            return false; // Email ya existe
        }
        $tries = 3;
        $done = false;
        // Verificar si el username ya existe
        while ($tries-- || !$done) {
            $stmt = $this->db->prepare(FIND_USERNAME_USER);
            $stmt->bindValue(":username", $username);
            $stmt->execute();
            // Username ya existe
            if ($stmt->fetch()) {
                $timestamp = (new DateTime())->getTimestamp();
                $suffix = substr(strval($timestamp), -5);
                $username = $username . "-" . $suffix;
            }else $done = true;
        }

        // Añadir usuario
        $token = bin2hex(random_bytes(32));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(INSERT_USER);
        //Manera de aglomerar los bindValues
        $params = [
            ":email" => $email,
            ":password" => $hashed_password,
            ":username" => $username,
            ":name" => $name,
            ":surname" => $surname,
            ":role" => "user",
            ":verification_token" => $token,
        ];
        return [
            "registerSuccess" => $stmt->execute($params),
            "token" => $token
        ];
    }
}
