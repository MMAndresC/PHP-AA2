<?php

session_start();
$message = $_SESSION['result_verification'] ?? '';
unset($_SESSION['result_verification']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="">

</head>

<body>
<header>
    <h1>Verificación de mail</h1>
</header>

<section id="container">
  <h1><?= $message ?></h1>
</section>
</body>
</html>