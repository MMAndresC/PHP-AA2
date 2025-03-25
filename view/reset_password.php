<?php

session_start();

$token = $_GET['token'] ?? '';
$errors = $_SESSION['errors'] ?? [];
$response = $_SESSION['response'] ?? '';
unset($_SESSION['errors'], $_SESSION['response']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<h3><?= $response ?></h3>
<form action="../controller/ResetPasswordController.php" method="post">
    <input type="hidden" name="token" value="<?= $token ?>">

    <?php if(trim($token) == ''){?>
        <!-- Campo Email-->
        <div class="div-input">
            <label class="" for="email">Email</label>
            <input type="text" class="user-form" name="email" id="email" placeholder="Email"
                   autofocus="<?= isset($errors['email']) ? 'autofocus' : '' ?>"
            >
            <span style="color:red;"><?= $errors['email'] ?? '' ?></span>
        </div>
    <?php } ?>

    <?php if(trim($token) != ''){?>
        <!-- Campo password  -->
        <div class="div-input">
            <label class="label-user-form" for="password">Contraseña</label>
            <input type="password" class="user-form" name="password" id="password" placeholder="Contraseña">
            <span style="color:red;"><?= $errors['password'] ?? '' ?></span>
        </div>

        <!-- Campo confirm password -->
        <div class="div-input">
            <label class="label-user-form" for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" class="user-form" name="confirm_password" id="confirm_password" placeholder="Confirmar contraseña">
            <span style="color:red;"><?= $errors['confirm_password'] ?? '' ?></span>
            <br>
        </div>
    <?php } ?>

    <input type="submit" name="reset_action"
           value="<?= trim($token) == '' ? 'Recuperar contraseña' : 'Guardar la nueva contraseña' ?>"
    >
</form>

</body>
</html>
