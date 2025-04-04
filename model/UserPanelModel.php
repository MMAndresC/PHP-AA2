<?php

use database\Database;

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../config/queries/db_queries_user.php";
require_once  __DIR__ . "/../util/process_image.php";
require_once __DIR__ . "/../util/log_error.php";

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
            logError($e->getMessage());
            return false;
        }
    }

    public function modifyUser($params): array
    {
        try{
            $response = ['data' => [], 'success' => false, 'errors' => []];

            //Buscar al usuario
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->execute([":email" => $params['email']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$data) {
                $response['errors']['critical'] = 'Email no encontrado en la base de datos';
                return $response;
            }

            $response['data'] = $data;

            //En caso de que haya que cambiar contraseña, verificarla
            if(trim($params['new_password']) != ""){
                if (!password_verify($params['password'], $data["password"])) {
                    $response['errors']['password'] = 'Password incorrecto';
                    return $response;
                }
            }

            $old_image = $data['image_name'];
            //Buscar si el username lo está usando otro usuario
            $stmt = $this->db->prepare(FIND_USERNAME_NOT_EMAIL_USER);
            $stmt->execute([":username" => $params['username'], ":email" => $params['email']]);
            if($stmt->fetch()){
                $response['errors']['username'] = 'Nombre de usuario ya existente';
                return $response;
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
            $response['data'] = $newData;
            $response["success"] = true;
            return $response;

        }catch (PDOException $e){
            logError($e->getMessage());
            $response['errors']['critical'] = 'Error en la base de datos';
            return $response;
        }
    }

    public function deleteUser($email, $password, $delete_content): int
    {
        try{
            $is_correct_password = $this->isCorrectPassword($email, $password);
            if(!$is_correct_password) return 0;
            // Si el delete_content es true, eliminamos los sub thread, hay que hacerlo antes porque si no
            //tal como está hecha la tabla si borra primero user pondrá el atributo author a null
            //por lo que la consulta de borrado posterior por author fallara
            if ($delete_content) {
                $stmt = $this->db->prepare(DELETE_SUB_THREAD_USER);
                $stmt->execute([":email" => $email]);
            }
            $stmt = $this->db->prepare(DELETE_USER);
            $stmt->execute([":email" => $email]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            logError($e->getMessage());
            return 0;
        }
    }

    public function isCorrectPassword($email, $password): bool
    {
        try{
            $stmt = $this->db->prepare(FIND_EMAIL_USER);
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $t = password_verify($password, $user["password"]);
            $u = isset($user);
            //Si existe que devuelva true, por eso está invertida la condición, porque si cumple eso es la opción mala
            return !(!$user || !password_verify($password, $user["password"]));
        }catch (PDOException $e){
            logError($e->getMessage());
            return false;
        }

    }
}