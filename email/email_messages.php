<?php

function getVerificationEmail($token,$name,$surname): string
{
    return "
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
            <p>Foro Ocio</p>
        </footer>
    </body>
    </html>";
}

function getResetPasswordEmail($email, $token): string
{
    return "
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
            <h1>Solicitud para cambiar la contraseña</h1>
        </header>
        <section>
            <article>
                <h3>Hola $email:<br>Ha solicitado un cambio de contraseña</h3>
                <br>
                <h4>Para cambiar la contraseña de tu cuenta, <a href='http://localhost/forum/view/reset_password.php?token=$token'>link</a></h4>
            </article>
        </section>
        <footer>
            <p>Foro Ocio</p>
        </footer>
    </body>
    </html>";
}

function getHeaders(): string
{
    $headers = "From: postmaster@localhost.com\r\n";
    //$headers .= "Reply-To: shinjii.ikari01@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    return $headers;
}