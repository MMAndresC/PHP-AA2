<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_user.php";

class ResetPasswordModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function sendMailToResetPassword($email): array
    {
        try{
            $stmt = $this->db->prepare(FIND_EMAIL_VERIFIED_USER);
            $stmt->execute([":email" => $email]);

            if(!$stmt->fetch()) return ["error" => "Email no está registrado"];

            try{
                $token = bin2hex(random_bytes(50));
            }catch (Exception $e){
                $token = bin2hex(openssl_random_pseudo_bytes(50));
            }

            $stmt = $this->db->prepare(UPDATE_RESET_PASSWORD);
            $stmt->execute([":reset_token" => $token, ":email" => $email]);
            return ["token" => $token];

        }catch (PDOException $e){
            return ["error" => "No es posible realizar la operación. Inténtelo más tarde"];
        }

    }
    function resetPassword($token, $password): string
    {
        try{
            $stmt = $this->db->prepare(FIND_RESET_PASSWORD_USER);
            $stmt->execute([":reset_token" => $token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$user) return "Enlace para cambio de contraseña no válido";

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare(UPDATE_CHANGE_PASSWORD);
            $stmt->execute([":password" => $hashed_password,":email" => $user['email']]);
            return "Contraseña actualizada";
        }catch (PDOException $e){
            return "No es posible realizar la operación. Inténtelo más tarde";
        }
    }
}