<?php

require_once __DIR__ . "/../config/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION['errors'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
$message = $_SESSION['message'] ?? '';
unset($_SESSION['errors'], $_SESSION['old_data'], $_SESSION['message']);

$mode = $_GET['mode'] ?? 'login';
$isRegister = ($mode === 'register');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
<header>
    <h1><?= $isRegister ? 'Registro de Usuario' : 'Inicio de Sesión' ?></h1>
</header>
    <h3><?= $message ?></h3>
    <section id="form">
        <div id="container-form">
            <form action="../controller/AuthController.php" method="post">
                <!-- Campo mode para diferenciar registro de login en el controlador -->
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <!-- Campo Email-->
                <div class="div-input">
                    <label class="label-user-form" for="email">Email</label>
                    <input type="text" class="user-form" name="email" id="email" placeholder="Email"
                           value="<?= htmlspecialchars($old_data['email'] ?? '') ?>"
                           autofocus="<?= isset($errors['email']) ? 'autofocus' : '' ?>"
                    >
                    <span style="color:red;"><?= $errors['email'] ?? '' ?></span>
                </div>

                <!-- Campo password  -->
                <div class="div-input">
                    <label class="label-user-form" for="password">Contraseña</label>
                    <input type="password" class="user-form" name="password" id="password" placeholder="Contraseña">
                    <span style="color:red;"><?= $errors['password'] ?? '' ?></span>
                </div>

                <!-- Todos los campos extras que tiene el registro-->
                <?php if ($isRegister){ ?>
                    <!-- Campo confirm password para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" class="user-form" name="confirm_password" id="confirm_password" placeholder="Confirmar contraseña">
                        <span style="color:red;"><?= $errors['confirm_password'] ?? '' ?></span>
                        <br>
                    </div>

                    <!-- Campo username para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="username">Nombre en el foro:</label>
                        <input type="text" class="user-form" name="username" id="username" placeholder="Username"
                               value="<?= htmlspecialchars($old_data['username'] ?? '') ?>"
                               autofocus="<?= isset($errors['username']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= $errors['username'] ?? '' ?></span>
                        <br>
                    </div>

                    <!-- Campo name para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="name">Nombre:</label>
                        <input type="text" class="user-form" name="name" id="name" placeholder="Nombre"
                               value="<?= htmlspecialchars($old_data['name'] ?? '') ?>"
                               autofocus="<?= isset($errors['name']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= $errors['name'] ?? '' ?></span>
                        <br>
                    </div>

                    <!-- Campo surname para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="surname">Apellido:</label>
                        <input type="text" class="user-form" name="surname" id="surname" placeholder="Apellido"
                               value="<?= htmlspecialchars($old_data['surname'] ?? '') ?>"
                               autofocus="<?= isset($errors['surname']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= $errors['surname'] ?? '' ?></span>
                        <br>
                    </div>

                <?php }; ?>

                <!-- Botón submit del formulario-->
                <input type="submit" name="login" value="<?= $isRegister ? 'Registrarse' : 'Iniciar Sesión' ?>">
                <?php if (!$isRegister){ ?>
                     <p class="p-registrar-login">
                        Has olvidado tu contraseña? Recuperar contraseña
                        <a class="log-reg" href="reset_password.php">
                            aquí
                        </a>
                     </p>
                <?php }; ?>
                <p class="p-registrar-login">
                    <?= $isRegister ? '¿Ya tienes una cuenta?' : '¿No tienes cuenta?' ?>
                    <a class="log-reg" href="?mode=<?= $isRegister ? 'login' : 'register' ?>">
                        <?= $isRegister ? 'Inicia sesión' : 'Regístrate' ?>
                    </a>
                </p>
            </form>
        </div>
    </section>
</body>
</html>

