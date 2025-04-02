<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = $_SESSION['result_verification'] ?? '';
unset($_SESSION['result_verification']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foro</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<section class="hero is-large is-success">
    <div class="hero-body">
        <p class="title">Verificación de mail</p>
        <p class="subtitle"><?= $message ?></p>
        <p class="buttons">
            <a href="../view/login.php">
                <button class="button" type="button">
                        <span class="icon">
                            <i class="fa fa-home"></i>
                        </span>
                    <span>Ir al login</span>
                </button>
            </a>
        </p>
    </div>
</section>
</body>
</html>