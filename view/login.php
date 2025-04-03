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

<script type="text/javascript">
    <?php require_once __DIR__ . "/../scripts/btnEventSubmitRegister.js"?>
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
    <header>
       <?php require_once __DIR__ . "/../components/nav_bar.php"?>
    </header>
    <h2 class="title is-2 has-text-centered mt-6 mb-4"><?= $isRegister ? 'Registro de Usuario' : 'Inicio de Sesión' ?></h2>
    <h3 class="title is-3 has-text-centered mb-2"><?= $message ?></h3>
    <section class="box form-width p-6">
        <form class="mb-4" action="../controller/AuthController.php" method="post" id="form-register">
            <!-- Campo mode para diferenciar registro de login en el controlador -->
            <input type="hidden" name="mode" value="<?= $mode ?>">
            <!-- Campo Email-->
            <div class="field mb-4">
                <p class="control has-icons-left has-icons-right">
                    <input class="input" type="email" placeholder="Email" name="email" id="email"
                           value="<?= htmlspecialchars($old_data['email'] ?? '') ?>"
                           autofocus="<?= isset($errors['email']) ? 'autofocus' : '' ?>"
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <?php if (isset($errors['email']) && $mode == 'register'){ ?>
                    <span class="icon is-small is-right">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <?php } ?>
                </p>
                <?php if (isset($errors['email'])){ ?>
                    <p class="help is-danger"><?= $errors['email'] ?></p>
                <?php } ?>
            </div>
            <!-- Campo password  -->
            <div class="field mb-4">
                <p class="control has-icons-left has-icons-right">
                    <input class="input" type="password" placeholder="Contraseña" name="password" id="password"
                           autofocus="<?= isset($errors['password']) && $mode == 'register' ? 'autofocus' : '' ?>"
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                    <?php if (isset($errors['password']) && $mode == 'register'){ ?>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    <?php } ?>
                </p>
                <?php if (isset($errors['password'])){ ?>
                    <p class="help is-danger"><?= $errors['password'] ?></p>
                <?php } ?>
            </div>

            <!-- Todos los campos extras que tiene el registro-->
            <?php if ($isRegister){ ?>
                <!-- Campo confirm password para el registro -->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="password" placeholder="Confirmar contraseña"
                               name="confirm_password" id="confirm_password"
                               autofocus="<?= isset($errors['confirm_password']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                        <?php if (isset($errors['confirm_password'])){ ?>
                            <span class="icon is-small is-right">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['confirm_password'])){ ?>
                        <p class="help is-danger"><?= $errors['confirm_password'] ?></p>
                    <?php } ?>
                </div>

                <!-- Campo username para el registro -->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Nombre de usuario"
                               name="username" id="username"
                               value="<?= htmlspecialchars($old_data['username'] ?? '') ?>"
                               autofocus="<?= isset($errors['username']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                        <i class="fas fa-user-ninja"></i>
                    </span>
                        <?php if (isset($errors['username'])){ ?>
                            <span class="icon is-small is-right">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['username'])){ ?>
                        <p class="help is-danger"><?= $errors['username'] ?></p>
                    <?php } ?>
                </div>

                <!-- Campo name para el registro -->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Nombre"
                               name="name" id="name"
                               value="<?= htmlspecialchars($old_data['name'] ?? '') ?>"
                               autofocus="<?= isset($errors['name']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                        <?php if (isset($errors['name'])){ ?>
                            <span class="icon is-small is-right">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['name'])){ ?>
                        <p class="help is-danger"><?= $errors['name'] ?></p>
                    <?php } ?>
                </div>

                <!-- Campo surname para el registro -->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Apellidos"
                               name="surname" id="surname"
                               value="<?= htmlspecialchars($old_data['surname'] ?? '') ?>"
                               autofocus="<?= isset($errors['surname']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                        <?php if (isset($errors['surname'])){ ?>
                            <span class="icon is-small is-right">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['surname'])){ ?>
                        <p class="help is-danger"><?= $errors['surname'] ?></p>
                    <?php } ?>
                </div>

                <!-- Checkbox con condiciones de uso -->
                <div class="field mb-4">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="use-terms" id="use-terms">
                            He leído y acepto <a>los términos y condiciones de uso</a>
                        </label>
                    </div>
                    <?php if (isset($errors['use-terms'])){ ?>
                        <p class="help is-danger"><?= $errors['use-terms'] ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <!-- Botón del formulario -->
            <div class="field is-grouped is-justify-content-center">
                <div class="control">
                    <button type="submit" class="button is-link is-light" name="<?= $mode ?>"
                            value="<?= $mode ?>" id="btn-register">
                        <?= $isRegister ? 'Registrarse' : 'Iniciar Sesión' ?>
                    </button>
                </div>
            </div>
        </form>

        <div class="card mt-3">
            <div class="card-content">
                <div class="content">
                    <?php if (!$isRegister){ ?>
                        <p class="subtitle is-6">
                            Has olvidado tu contraseña? Recuperar contraseña
                            <a class="log-reg" href="reset_password.php">
                                aquí
                            </a>
                        </p>
                    <?php } ?>
                    <p class="subtitle is-6">
                        <?= $isRegister ? '¿Ya tienes una cuenta?' : '¿No tienes cuenta?' ?>
                        <a class="log-reg" href="?mode=<?= $isRegister ? 'login' : 'register' ?>">
                            <?= $isRegister ? 'Inicia sesión' : 'Regístrate' ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

