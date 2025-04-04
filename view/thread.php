<?php

require_once __DIR__ . "/../config/config_error.php";
require_once __DIR__ . "/../controller/ThreadController.php";
require_once __DIR__ . "/../controller/ThemeController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;

$theme_id = (int) $_GET['id-theme'] ?? null;
if ($theme_id === null) {
    header("Location: theme.php");
    exit();
}

//Paginación de los threads
$FORMAT_DATE = "d/m/Y H:i";
$LIMIT = 5;
$page = (int) $_GET['pag'] ?? 0;
$response = ThreadController::getThreadsByTheme($theme_id, $LIMIT, $page * $LIMIT);
$total_registers = (int) $response['count'] ?? 0;
$last_page = ceil($total_registers / $LIMIT);
$threads = $response['threads'] ?? [];

//Conseguir los datos del tema actual
$themes = $_SESSION['themes'] ?? [];
if(!empty($themes)) {
    $themes_find = array_filter($themes, function ($theme) use ($theme_id) {
        return $theme['id'] === $theme_id;
    });
    $theme_actual = reset($themes_find); //Devuelve el primer elemento de la array o falso si no hay nada
}
if(empty($themes) || !$theme_actual) {
    $theme_actual = ThemeController::getTheme($theme_id);
}
$name_theme = $theme_actual['name'] ?? '';
$_SESSION['theme_id'] = $theme_id;

//Breadcrumb
$bc_theme = ["theme_id" => $theme_id, "name" => $name_theme];
$_SESSION['breadcrumbs']['theme'] = $bc_theme;

//Respuesta de la base de datos
$errors = $_SESSION['errors'] ?? [];
$error_critical = $_SESSION['error_critical'] ?? false;
$result = $_SESSION['result-thread'] ?? false;

unset($_SESSION['errors'], $_SESSION['error_critical'], $_SESSION['result-thread']);

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

    <div class="container mb-6 mt-6">
        <p class="has-text-centered is-size-2 mt-2"><?= $name_theme?></p>

        <!-- Breadcrumb-->
        <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="theme.php">Temas</a></li>
                <li class="is-active"><a aria-current="page"><?= $bc_theme['name']?></a></li>
            </ul>
        </nav>

        <?php if($user !== null){ ?>
            <a href="#new-thread"
               class="tag is-light is-primary is-medium">Nuevo mensaje</a>
        <?php } ?>
    </div>

    <main class="container">
        <!-- Toast cuando se haya editado el usuario, confirme que se ha hecho bien-->
        <?php if($result || $error_critical){ ?>
            <article class="message <?= $result ? 'is-success' : 'is-warning'?> " id="toast">
                <div class="message-header">
                    <?php if($result){ ?>
                        <p><?= $result ?></p>
                    <?php } else { ?>
                        <p><?= $error_critical ?></p>
                    <?php } ?>
                    <button class="delete" aria-label="delete" onclick="document.getElementById('toast').remove()"></button>
                </div>
            </article>
        <?php } ?>

        <!-- Paginación -->
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
            <!-- Botones anterior/siguiente-->
            <?php if($page != 0){?>
                <a href="thread.php?pag=<?= $page - 1 ?>&id-theme=<?= $theme_id ?>"
                   class="pagination-previous">Anterior</a>
            <?php }else {?>
                <button class="pagination-previous" disabled>Anterior</button>
            <?php } ?>
            <?php if(($page + 1) != $last_page){?>
                <a href="thread.php?pag=<?= $page + 1 ?>&id-theme=<?= $theme_id ?>"
                   class="pagination-next">Siguiente</a>
            <?php }else {?>
                <button class="pagination-previous" disabled>Siguiente</button>
            <?php } ?>

            <!-- Botones con números-->
            <ul class="pagination-list">
                <li>
                    <a <?= $page != 0 ? 'href="thread.php?pag=0&id-theme=' . $theme_id. '"' : ''?>
                       class="pagination-link <?= $page == 0 ? 'is-current' : ''?>" aria-label="Ir a página 1">1
                    </a>
                </li>
                <!-- ... -->
                <?php if($page > 2){ ?>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                <?php } ?>
                <!-- anterior al seleccionado -->
                <?php if($page >= 2){ ?>
                    <li><a href="thread.php?pag=<?= $page - 1?>&id-theme=<?= $theme_id ?>"
                           class="pagination-link" aria-label="Ir a página <?= $page ?>"><?= $page ?></a>
                    </li>
                <?php } ?>
                <!-- seleccionado -->
                <?php if($page != 0 && $page + 1 != $last_page){ ?>
                    <li>
                        <a
                                class="pagination-link is-current"
                                aria-label="<?= $page + 1 ?>"
                                aria-current="page"
                        ><?= $page + 1 ?></a
                        >
                    </li>
                <?php } ?>
                <!-- Posterior al seleccionado -->
                <?php if($page + 2 < $last_page){ ?>
                    <li><a href="thread.php?pag=<?= $page + 1 ?>&id-theme=<?= $theme_id ?>"
                           class="pagination-link" aria-label="Ir a página <?= $page + 2 ?>"><?= $page + 2 ?></a>
                    </li>
                <?php } ?>
                <!-- ... -->
                <?php if(($page + 2) < ($last_page - 1)){ ?>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                <?php } ?>
                <!-- Último botón -->
                <?php if($last_page > 1 ){ ?>
                    <li>
                        <a <?= $page + 1 != $last_page ? 'href="thread.php?pag='. ($last_page - 1) . '&id-theme=' . $theme_id. '"' : ''?>
                           class="pagination-link <?= $page + 1 == $last_page ? 'is-current' : ''?>"
                           aria-label="Ir a página "<?= $last_page ?>><?= $last_page ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <?php foreach ($threads as $thread){ ?>
            <article class="message">
                <a href="sub_thread.php?pag=0&id-thread=<?= $thread['id'] ?>">
                    <div class="message-header">
                        <p class="subtitle is-5"><?= ucfirst($thread['title'] ?? "") ?></p>
                    </div>
                </a>
                <div class="message-body">
                    <section class="level">
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Creado por</p>
                                <p class="subtitle is-5"><?= $thread['author'] ?? 'Anónimo'?></p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Última actualización</p>
                                <p class="subtitle is-5">
                                    <?= date_format(date_create($thread['updated_at']), $FORMAT_DATE) ?>
                                </p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Último mensaje por</p>
                                <p class="subtitle is-5"><?= $thread['updater'] ?? 'Anónimo' ?></p>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Formulario de edición del admin-->
                <?php if(isset($user) && $user['role'] === 'admin'){ ?>
                <section class="hero is-warning is-small">
                    <div class="hero-body">
                        <form class="user-form is-display-flex is-flex-direction-column"
                              action="../controller/ThreadController.php" method="post"
                        >
                            <div class="field is-horizontal is-justify-content-space-around">
                                <input type="hidden" id="edit-thread-id-<?= $thread['id'] ?>" name="thread_id" value="<?= $thread['id'] ?>">
                                <input type="hidden" id="edit-old-theme-<?= $thread['id'] ?>" name="old-theme-id" value="<?= $theme_id ?>">
                                <input id="edit-title-<?= $thread['id'] ?>" class="input is-info"
                                       style="max-width: 50%;"
                                       value="<?= $thread['title'] ?>" name="title"
                                >
                                <label class="checkbox">
                                    <input id="edit-status-<?= $thread['id'] ?>" type="checkbox"
                                           name="is-closed" <?= $thread['status'] == 'closed' ? 'checked' : '' ?>/>
                                    Cerrar el hilo
                                </label>
                                <div class="select is-info is-small">
                                    <select name="theme_id" id="edit-theme-<?= $thread['id'] ?>">
                                        <?php foreach ($themes as $theme){ ?>
                                            <option value="<?= $theme['id']?>"
                                                <?= $theme['id'] == $theme_id ? 'selected' : ''?>
                                            ><?= $theme['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php if(isset($errors['edition'])){ ?>
                                <p class="help is-danger"><?= $errors['edition'] ?></p>
                            <?php } ?>

                            <div class="is-display-flex is-justify-content-center mt-3">
                                <button id="btn-edit-<?= $thread['id'] ?>"
                                        class="button tag is-small is-primary is-light"
                                        name="action-thread" value="edit-thread" >Guardar cambios
                                </button>
                                <button type="button" id="btn-delete-<?= $thread['id'] ?>"
                                        class="button tag is-small is-light is-danger js-modal-trigger ml-3"
                                        data-target="modal-delete-<?=$thread['id']?>">
                                    Borrar el hilo completo
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Borrar el thread por el admin-->
                    <div id="modal-delete-<?= $thread['id']?>" class="modal">
                        <div class="modal-background"></div>
                        <div class="modal-card">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Borrar el hilo</p>
                                <button class="delete" aria-label="close"></button>
                            </header>
                            <form class="user-form" method="post" action="../controller/ThreadController.php">
                                <section class="modal-card-body">
                                    <input type="hidden" name="email" value="<?= $user['email'] ?>">
                                    <input type="hidden" name="thread_id" value="<?= $thread['id'] ?>">
                                    <input type="hidden" name="page" value="<?= $page ?>">
                                    <input type="hidden" name="theme_id" value="<?= $theme_id ?>">
                                    <label class="has-text-danger" for="password">Confirmar contraseña</label>
                                    <input class="input is-small" type="password" name="password" id="password" placeholder="Contraseña" />
                                </section>
                                <footer class="modal-card-foot">
                                    <div class="buttons">
                                        <button type="submit" class="tag is-danger" name="action-thread" value="delete-thread">Borrar</button>
                                        <button type="button" class="button tag is-link">Cancelar</button>
                                    </div>
                                </footer>
                            </form>
                        </div>
                    </div>
                </section>
                <?php } ?>
            </article>
        <?php } ?>

        <?php if($user !== null){ ?>
            <!-- Formulario para un nuevo thread-->
            <form action="../controller/ThreadController.php" method="post" class="user-form box" id="new-thread">
                <input class="input" type="hidden" name="author" id="author" value="<?= $user['email'] ?>">
                <input class="input" type="hidden" name="theme_id" id="theme_id" value="<?= $theme_id ?>">
                <div class="field">
                    <label class="label" for="title">Título</label>
                    <div class="control">
                        <input class="input is-info" type="text" placeholder="Título del nuevo hilo" name="title" id="title" required>
                    </div>
                    <?php if(isset($errors['title'])){ ?>
                        <p class="help is-danger"><?= $errors['title'] ?></p>
                    <?php } ?>
                </div>
                <div class="field">
                    <label class="label" for="content">Mensaje</label>
                    <div class="control">
                        <textarea class="textarea is-info textarea-min-height" type="text" name="content" id="content"
                                  rows="8" cols="50" required></textarea>
                    </div>
                    <?php if(isset($errors['content'])){ ?>
                        <p class="help is-danger"><?= $errors['content'] ?></p>
                    <?php } ?>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" name="action-thread" value="add-thread">Nuevo mensaje</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light" type="reset">
                            Limpiar
                        </button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </main>
    <?php require_once __DIR__ . "/../components/footer.php"?>
</body>
</html>

