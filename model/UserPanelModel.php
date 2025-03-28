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

            //Buscar al usuario
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->execute([":email" => $params['email']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$data) {
                $errors['critical'] = 'Email no encontrado en la base de datos';
                return ['errors' => $errors];
            }

            //En caso de que haya que cambiar contraseña, verificarla
            if(trim($params['new_password']) != ""){
                if (!password_verify($params['password'], $data["password"])) {
                    $errors['password'] = 'Password incorrecto';
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
            }else {
                // En el caso de que no se mande imagen nueva, pero ya hubiera una guardada para no borrar con nulo la guardada
                if($old_image !== null) $image_name = $old_image;
                else $image_name = null;
            }
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
            if($old_image !== null && $old_image != $image_name) deleteImage($old_image);
            $newData = [
                "username" => $params['username'],
                "email" => $params['email'],
                "name" => $params['name'],
                "surname" => $params['surname'],
                "image_name" => $image_name
            ];
            return ['data' => $newData, 'success' => true];

        }catch (PDOException $e){
            $errors['critical'] = 'Error en la base de datos';
            return ['errors' => $errors];
        }
    }

    public function deleteUser($email, $password, $deleteContent): int
    {
        try{
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user["password"])) {
                // Si no existe el usuario o la contraseña es incorrecta, no hacemos nada
                return 0;
            }

            $stmt = $this->db->prepare(DELETE_USER);
            $stmt->execute([":email" => $email]);
            $result = $stmt->rowCount();

            // Si se eliminó el usuario y deleteContent es true, eliminamos su contenido asociado
            if ($result > 0 && $deleteContent) {
                $stmt = $this->db->prepare(DELETE_SUB_THREAD_USER);
                $stmt->execute([":email" => $email]);
            }

            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }
}