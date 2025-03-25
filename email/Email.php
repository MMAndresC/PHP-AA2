<?php

require_once "email_messages.php";
class Email
{
    public static function sendVerificationEmail($mail_data): string
    {
        try{
            $username = $mail_data['username'];
            $name = $mail_data["name"];
            $surname = $mail_data["surname"];
            $to = $mail_data["email"];
            $subject = 'Confirmación de registro: ' . $username;
            $token = $mail_data['token'];

            $message = getVerificationEmail($token, $name, $surname);

            $headers = getHeaders();

            // Envía email.
            $result = mail($to, $subject, $message, $headers);
            if($result)
                return "Mail enviado";
            else
                return "Mail no se ha podido enviar";
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public static function sendResetPasswordEmail($to, $token): string
    {
        try{
            $headers = getHeaders();
            $message = getResetPasswordEmail($to, $token);
            $subject = 'Reset de contraseña';
            $result = mail($to, $subject, $message, $headers);
            if($result)
                return "Mail enviado";
            else
                return "Mail no se ha podido enviar";
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
}