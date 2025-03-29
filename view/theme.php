<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$theme_id = $_GET['id-theme'] ?? null;
if ($theme_id === null) {
    header("Location: main.php");
    exit();
}

?>

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
    <?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
</header>

</body>
</html>

