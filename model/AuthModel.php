<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_user.php";
require_once __DIR__ . "/../util/log_error.php";

class AuthModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function login($email, $password)
    {
        try{
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
        }catch (PDOException $e){
            logError("AuthModel-Login: " . $e->getMessage());
        }
    }

    public function register($email, $password, $username, $name, $surname): array
    {
        try{
            // Verificar si el email ya existe
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            // Email ya existe, ver si está verificado y si el token está caducado
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user){
                //Sí está caducado, borrar usuario y seguir el proceso normal
                if(!$user['verified'] && strtotime($user['verification_expires']) < time()) {
                    $stmt = $this->db->prepare(DELETE_USER);
                    $stmt->bindValue(":email", $email);
                    $stmt->execute();
                }else{
                    return ["registerSuccess" => false];
                }
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
            try{
                // Añadir usuario
                $token = bin2hex(random_bytes(32));
            }catch (Exception $e){
                $token = bin2hex(openssl_random_pseudo_bytes(32));
            }

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
        }catch (PDOException $e){
            logError("AuthModel-Register: " . $e->getMessage());
            return ["registerSuccess" => false];
        }

    }
}
