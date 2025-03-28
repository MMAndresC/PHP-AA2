<?php

use database\Database;

require_once "../config/Database.php";

$message = '';

if (isset($_GET['token'])) {
    try{
        //Coger el token del link
        $token = $_GET['token'];

        //Buscar el usuario con ese token de verificación
        $connection = Database::connect();
        $stmt = $connection->prepare(FIND_VERIFICATION_TOKEN_USER);
        $stmt->bindValue(':verification_token', $token);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user){
            $stmt = $connection->prepare(UPDATE_VERIFIED_USER);
            $stmt->bindValue(':email', $user['email']);
            $stmt->execute();
            $message = "Mail verificado con éxito";
        }else{
            $message = "El link ya no es válido";
        }
    }catch (PDOException|Exception $e){
        $message = "No se ha podido verificar su mail";
    }
}else{
    $message = "No se ha podido recuperar el token de verificación";
}

session_start();
$_SESSION['result_verification'] = $message;

header("Location: ../view/verification.php");
