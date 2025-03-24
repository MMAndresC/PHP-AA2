<?php

class Email
{
    public static function sendEmail($mail_data): string
    {
        try{
            $username = $mail_data['username'];
            $name = $mail_data["name"];
            $surname = $mail_data["surname"];
            $to = $mail_data["email"];
            $subject = 'Confirmación de registro: ' . $username;
            $token = $mail_data['token'];

            $message = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        * {font-family: 'Arial', Helvetica, sans-serif;}
        body {width: 80%; margin: 0 auto; background-color: aqua;}
        td {border: 1px solid black;}
    </style>
</head>
<body>
    <header>
        <h1>Confirmación de registro</h1>
    </header>
    <section>
        <article>
            <h3>Hola $name $surname:<br>Su Cuenta ha sido creada con éxito.</h3>
            <br>
            <h4>Confirme su email en este <a href='http://localhost/forum/email/verify.php?token=$token'>link</a></h4>
        </article>
    </section>
    <footer>
        <p>Foro La Rueda del Tiempo</p>
    </footer>
</body>
</html>";

            $headers = "From: postmaster@localhost.com\r\n";
            $headers .= "Reply-To: shinjii.ikari01@gmail.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();


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
}