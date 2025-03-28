<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = false;
if(!isset($_SESSION["user"])){
    $isLoggedIn = true;

}?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
<header>
    <?php require_once "../components/nav_bar.php"; ?>
</header>
<h1>FORO</h1>
</body>
</html>
