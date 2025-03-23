<?php

session_start();

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
unset($_SESSION['errors'], $_SESSION['old_data']);

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';
$isRegister = ($mode === 'register');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
<header>
    <h1><?= $isRegister ? 'Registro de Usuario' : 'Inicio de Sesión' ?></h1>
    <nav>
        <label for="check-menu">
            <input id="check-menu" type="checkbox">
            <div class="btn-menu">Menú</div>
            <ul class="ul-menu">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="login.php">Acceder</a></li>
                <li><a href="login.php<?= '?registrar'; ?>">Registrarse</a></li>
            </ul>
        </label>
    </nav>
</header>
    <section id="form">
        <div id="container-form">
            <form action="../controller/UserController.php" method="post">
                <input type="hidden" name="mode" value="<?= $mode ?>">
                <!-- Campo Email-->
                <div class="div-input">
                    <label class="label-user-form" for="email">Email</label>
                    <input type="text" class="user-form" name="email" id="email" placeholder="Email"
                           value="<?= htmlspecialchars(isset($old_data['email']) ? $old_data['email'] : '') ?>"
                           autofocus="<?= isset($errors['email']) ? 'autofocus' : '' ?>"
                    >
                    <span style="color:red;"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
                </div>

                <!-- Campo password  -->
                <div class="div-input">
                    <label class="label-user-form" for="password">Contraseña</label>
                    <input type="password" class="user-form" name="password" id="password" placeholder="Contraseña">
                    <span style="color:red;"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
                </div>

                <!-- Todos los campos extras que tiene el registro-->
                <?php if ($isRegister){ ?>
                    <!-- Campo confirm password para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" class="user-form" name="confirm_password" id="confirm_password" placeholder="Password">
                        <span style="color:red;"><?= isset($errors['confirm_password']) ? $errors['confirm_password'] : '' ?></span>
                        <br>
                    </div>

                    <!-- Campo username para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="username">Nombre en el foro:</label>
                        <input type="text" class="user-form" name="username" id="username" placeholder="Username"
                               value="<?= htmlspecialchars(isset($old_data['username']) ? $old_data['username'] : '') ?>"
                               autofocus="<?= isset($errors['username']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= isset($errors['username']) ? $errors['username'] : '' ?></span>
                        <br>
                    </div>

                    <!-- Campo name para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="name">Nombre:</label>
                        <input type="text" class="user-form" name="name" id="name" placeholder="Nombre"
                               value="<?= htmlspecialchars(isset($old_data['name']) ? $old_data['name'] : '') ?>"
                               autofocus="<?= isset($errors['name']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
                        <br>
                    </div>

                    <!-- Campo surname para el registro -->
                    <div class="div-input">
                        <label class="label-user-form" for="surname">Apellido:</label>
                        <input type="text" class="user-form" name="surname" id="surname" placeholder="Apellido"
                               value="<?= htmlspecialchars(isset($old_data['surname']) ? $old_data['surname'] : '') ?>"
                               autofocus="<?= isset($errors['surname']) ? 'autofocus' : '' ?>"
                        >
                        <span style="color:red;"><?= isset($errors['surname']) ? $errors['surname'] : '' ?></span>
                        <br>
                    </div>

                <?php }; ?>

                <!-- Botón submit del formulario-->
                <input type="submit" name="login" value="<?= $isRegister ? 'Registrarse' : 'Iniciar Sesión' ?>">
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

