<?php

require_once __DIR__ . "/../config/config_error.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION["errors"] ?? [];
$data = $_SESSION["data"] ?? [];
$user = $_SESSION["user"] ?? [];
$success = $_SESSION["success"] ?? false;
$failed_delete = $_SESSION["failed_delete"] ?? false;
unset($_SESSION["errors"],$_SESSION["success"], $_SESSION["failed_delete"]);

if(!$user){
    header("Location:login.php");
    exit();
}

?>

<script type="text/javascript">
    <?php require_once "../scripts/userPanelScript.js"?>
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foro</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
<header>
<?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
</header>

<main class="container mt-6">

    <!-- Toast cuando se haya editado el usuario, confirme que se ha hecho bien-->
    <?php if($success || $failed_delete){ ?>
        <article class="message <?= $success ? 'is-success' : 'is-warning'?> " id="toast">
            <div class="message-header">
                <?php if($success){ ?>
                    <p>Datos modificados con éxito</p>
                <?php } else { ?>
                    <p>No se ha podido borrar la cuenta, email o password no correctos</p>
                <?php } ?>
                <button class="delete" aria-label="delete" onclick="document.getElementById('toast').remove()"></button>
            </div>
        </article>
    <?php } ?>

    <form class="user-form box" action="../controller/UserPanelController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="email" id="email" value="<?= $data['email'] ?>" readonly>
        <div class="is-flex-direction-row is-display-flex field is-align-items-center" id="container-image">
            <div>
                <figure class="image is-128x128 cursor-type" onclick="document.getElementById('image').click()">
                    <img class="is-rounded wid" id="previewImg"
                         style="max-width: 100%; max-height: 100%; object-fit: contain;"
                         src="<?= $data['image_name'] != null ? "../../uploads/" . $data['image_name'] : "../assets/images/no_image.jpg"; ?>"
                         alt="avatar"
                    />
                </figure>
                <input type="file" name="image" id="image" accept="image/*" class="is-display-none"/>
            </div>

            <div class="ml-5" style="width: 100%;">
                <label class="label" for="username">Nombre de usuario</label>
                <div class="control">
                    <input class="input <?= isset($errors['username']) ? 'is-danger' : ''?>"
                           type="text" placeholder="Nombre de usuario"
                           name="username" id="username" required
                           value="<?= $data['username'] ?>"
                    >
                </div>
                <?php if (isset($errors['username'])){ ?>
                    <p class="help is-danger"><?= $errors['username'] ?></p>
                <?php } ?>
            </div>
        </div>


        <div class="is-flex-direction-row is-display-flex field is-align-items-center" >
           <div style="width: 50%;">
               <label class="label" for="name">Nombre</label>
               <div class="control">
                   <input class="input <?= isset($errors['name']) ? 'is-danger' : ''?>"
                          type="text" placeholder="Nombre"
                          name="name" id="name" required
                          value="<?= $data['name'] ?>"
                   >
               </div>
               <?php if (isset($errors['name'])){ ?>
                   <p class="help is-danger"><?= $errors['name'] ?></p>
               <?php } ?>
           </div>
           <div class="ml-5" style="width: 50%;">
               <label class="label" for="surname">Apellidos</label>
               <div class="control">
                   <input class="input <?= isset($errors['surname']) ? 'is-danger' : ''?>"
                          type="text" placeholder="Apellidos"
                          name="surname" id="surname" required
                          value="<?= $data['surname'] ?>"
                   >
               </div>
               <?php if (isset($errors['surname'])){ ?>
                   <p class="help is-danger"><?= $errors['surname'] ?></p>
               <?php } ?>
           </div>
        </div>

        <div class="field mt-4">
            <p class="help is-danger">*Solo para cambiar contraseña</p>
            <label class="label" for="password">Contraseña actual</label>
            <p class="control has-icons-left">
                <input class="input <?= isset($errors['password']) ? 'is-danger' : ''?>"
                       type="password" placeholder="Contraseña actual"
                       name="password" id="password"
                >
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
            <?php if (isset($errors['password'])){ ?>
                <p class="help is-danger"><?= $errors['password'] ?></p>
            <?php } ?>
        </div>

        <div class="field mb-6">
            <label class="label" for="new_password">Nueva contraseña</label>
            <div class="control has-icons-left">
                <input class="input <?= isset($errors['new_password']) ? 'is-danger' : ''?>"
                       type="password" placeholder="Nueva contraseña"
                        name="new_password" id="new_password"
                >
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <?php if (isset($errors['new_password'])){ ?>
                <p class="help is-danger"><?= $errors['new_password'] ?></p>
            <?php } ?>
        </div>

        <!-- Botones del formulario -->
        <div class="field is-grouped is-justify-content-center">
            <div class="control">
                <button type="button" class="button is-light is-warning js-modal-trigger" data-target="modal-edit">
                    Modificar
                </button>
            </div>
            <div class="control">
                <button type="button" class="button is-light is-danger js-modal-trigger" data-target="modal-delete">Eliminar cuenta</button>
            </div>
        </div>

        <!-- Modales para confirmar acciones -->
        <!-- Editar los datos de usuario -->
        <div id="modal-edit" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Modificar datos</p>
                    <button class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <p>¿Guardar los nuevos datos?</p>
                </section>
                <footer class="modal-card-foot">
                    <div class="buttons">
                        <button type="submit" name="action" value="edit" class="button is-success">Si</button>
                        <button class="button">Cancelar</button>
                    </div>
                </footer>
            </div>
        </div>

    </form>

    <!-- Borrar la cuenta de usuario -->
    <div id="modal-delete" class="modal">
        <div class="modal-background"></div>
        <form class="modal-card user-form" action="../controller/UserPanelController.php" method="post">
            <header class="modal-card-head">
                <p class="modal-card-title">Borrar la cuenta</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <p>¿Borrar la cuenta de usuario?</p>
                <p class="is-danger" style="color: darkred;">Está acción no se puede deshacer </p>
            </section>
            <section class="box">
                <span>Confirmar datos</span>
                <div class="field">
                    <label class="label" for="email_delete">Email</label>
                    <div class="control">
                        <input class="input" type="text" name="email_delete" id="email_delete" placeholder="Email registrado">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="password_delete">Contraseña</label>
                    <div class="control">
                        <input class="input" type="password" name="password_delete" id="password_delete" placeholder="Contraseña">
                    </div>
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="content_delete" id="content_delete"/>
                        Borrar todos los mensajes
                    </label>
                    <span class="help is-warning">Marcando la casilla también se borrarán todos tus mensajes del foro</span>
                </div>
            </section>
            <footer class="modal-card-foot">
                <div class="buttons">
                    <button type="submit" name="action" value="delete" class="button is-success">Si</button>
                    <button class="button">Cancelar</button>
                </div>
            </footer>
        </form>
    </div>
</main>
<?php require_once __DIR__ . "/../components/footer.php"?>

</body>

</html>

