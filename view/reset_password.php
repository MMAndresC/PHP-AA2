<?php

require_once __DIR__ . "/../config/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$token = $_GET['token'] ?? '';
$errors = $_SESSION['errors'] ?? [];
$response = $_SESSION['response'] ?? null;
unset($_SESSION['errors'], $_SESSION['response']);

?>

<script type="text/javascript">
    <?php require_once __DIR__ . "/../scripts/btnEventSubmitReset.js" ?>
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
        <?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
    </header>
    <h2 class="title is-2 has-text-centered mt-6 mb-6">Recuperación contraseña</h2>
    <section class="box form-width p-6 mb-6">
        <form action="../controller/ResetPasswordController.php" method="post" id="form-reset">
            <input type="hidden" name="token" value="<?= $token ?>">

            <?php if(trim($token) == ''){?>
                <!-- Campo Email-->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="email" placeholder="Email" name="email" id="email"
                               autofocus="<?= isset($errors['email']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        <?php if (isset($errors['email'])){ ?>
                            <span class="icon is-small is-right">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['email'])){ ?>
                        <p class="help is-danger"><?= $errors['email'] ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if(trim($token) != ''){?>
                <!-- Campo password  -->
                <div class="field mb-4">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="password" placeholder="Contraseña" name="password" id="password"
                               autofocus="<?= isset($errors['password']) ? 'autofocus' : '' ?>"
                        >
                        <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        <?php if (isset($errors['password'])){ ?>
                            <span class="icon is-small is-right">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </span>
                        <?php } ?>
                    </p>
                    <?php if (isset($errors['password'])){ ?>
                        <p class="help is-danger"><?= $errors['password'] ?></p>
                    <?php } ?>
                </div>

                <!-- Campo confirm password -->
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
            <?php } ?>
            <!-- Botón del formulario -->
            <div class="field is-grouped is-justify-content-center mt-6">
                <div class="control">
                    <button type="submit" class="button is-link is-light" id ="btn-reset" name="reset_action">
                        <?= trim($token) == '' ? 'Recuperar contraseña' : 'Guardar la nueva contraseña' ?>
                    </button>
                </div>
            </div>

        </form>
    </section>
    <!-- Mostrar resultado -->
    <?php if(isset($response)){ ?>
        <div class="notification form-width is-link is-light" id="notification">
            <button class="delete" onclick="document.getElementById('notification').remove()"></button>
           <p><?= $response ?></p>
        </div>
    <?php } ?>

</body>
</html>
