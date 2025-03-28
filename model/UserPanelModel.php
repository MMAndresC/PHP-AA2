<?php

use database\Database;

require_once "../config/Database.php";
require_once  "../config/db_queries.php";
require_once  "../util/process_image.php";

class UserPanelModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    public function getUserByEmail($email){
        try{
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) {
                unset($user["password"]);
                return $user;
            }
            return false;
        }catch(PDOException $e){
            return false;
        }
    }

    public function modifyUser($params): array
    {
        try{
            $errors = array();
            if(trim($params['new_password']) != ""){
                $hashed_password = password_hash($params['password'], PASSWORD_DEFAULT);
                //Que esté el usuario y que el password coincida
                $stmt = $this->db->prepare(FIND_EMAIL_PASSWORD_USER);
                $stmt->execute([":email" => $params['email'], ":password" => $hashed_password]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!$data) {
                    $errors['password'] = 'Password incorrecto';
                    return ['errors' => $errors];
                }
            }else{
                $stmt = $this->db->prepare(FIND_EMAIL_USER);
                $stmt->execute([":email" => $params['email']]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!$data) {
                    $errors['critical'] = 'Email no encontrado en la base de datos';
                    return ['errors' => $errors];
                }
            }
            $old_image = $data['image_name'];
            //Buscar si el username lo está usando otro usuario
            $stmt = $this->db->prepare(FIND_USERNAME_NOT_EMAIL_USER);
            $stmt->execute([":username" => $params['username'], ":email" => $params['email']]);
            if($stmt->fetch()){
                $errors['username'] = 'Nombre de usuario ya existente';
                return ['errors' => $errors];
            }
            //Preparar los datos para hacer el update diferenciando si han mandado cambio de password
            // Tratar la imagen
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $image_name = process_image($_FILES["image"]);
                if(trim($image_name) === "") $image_name = null;
            }else $image_name = null;
            if(trim($params['new_password']) != ""){
                $hashed_password = password_hash($params['new_password'], PASSWORD_DEFAULT);
                $stmt = $this->db->prepare(UPDATE_EDIT_USER_WITH_PASS);
                $stmt->execute([
                    ":username" => $params['username'],
                    ":email" => $params['email'],
                    ":name" => $params['name'],
                    ":surname" => $params['surname'],
                    ":password" => $hashed_password,
                    "image_name" => $image_name
                ]);
            }else{
                $stmt = $this->db->prepare(UPDATE_EDIT_USER_WITHOUT_PASS);
                $stmt->execute([
                    ":username" => $params['username'],
                    ":email" => $params['email'],
                    ":name" => $params['name'],
                    ":surname" => $params['surname'],
                    "image_name" => $image_name
                ]);
            }
            //Borrar la imagen almacenada anterior si existía
            if($old_image !== null) deleteImage($old_image);
            $newData = [
                "username" => $params['username'],
                "email" => $params['email'],
                "name" => $params['name'],
                "surname" => $params['surname'],
                "image_name" => $image_name
            ];
            return ['data' => $newData];

        }catch (PDOException $e){
            $errors['critical'] = 'Error en la base de datos';
            return ['errors' => $errors];
        }
    }
}