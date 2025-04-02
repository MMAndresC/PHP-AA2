<?php

require_once __DIR__ . "/../controller/SubThreadController.php";
require_once __DIR__ . "/../controller/ThreadController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$thread_id = (int) $_GET['id-thread'] ?? null;
//TODO llevar a una vista de error
if ($thread_id === null) {
    header("Location: theme.php");
    exit();
}
$title = ThreadController::getTitle($thread_id);
$bc_thread = ["thread_id" =>$thread_id, "title" => $title];
$bc_theme = $_SESSION['breadcrumbs']['theme'];

$FORMAT_DATE = "h:iA - d M, Y ";
$LIMIT = 5;
$page = (int) $_GET['pag'] ?? 0;
$response = SubThreadController::getSubThreadsData($thread_id, $LIMIT, $page * $LIMIT);
$total_registers = (int) $response['count'] ?? 0;
$last_page = ceil($total_registers / $LIMIT);
$sub_threads = $response['sub_threads'] ?? [];

$user = $_SESSION['user'] ?? null;

$errors = $_SESSION['errors'] ?? [];
$result = $_SESSION['result-sub-thread'] ?? false;
$critical_error = $_SESSION['critical_error'] ?? false;

unset($_SESSION['errors'],$_SESSION['result-sub-thread'], $_SESSION['critical_error']);

?>

<script type="text/javascript">
    <?php require_once "../scripts/userPanelScript.js"?>
    <?php require_once "../scripts/editTextareaScript.js"?>
</script>


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

    <div class="container mb-6 mt-6">
        <p class="has-text-centered is-size-2 mt-2"><?= ucfirst($bc_thread['title'])?></p>

        <!-- Breadcrumb-->
        <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="theme.php">Temas</a></li>
                <li><a href="thread.php?pag=0&id-theme=<?= $bc_theme['theme_id']?>"><?= ucfirst($bc_theme['name'])?></a></li>
                <li class="is-active"><a aria-current="page"><?= ucfirst($bc_thread['title']) ?></a></li>
            </ul>
        </nav>

        <?php if($user !== null){ ?>
            <a href="#new-sub-thread"
               class="tag is-medium is-primary is-light">Nuevo mensaje</a>
        <?php } ?>
    </div>

    <main class="container">
        <!-- Toast cuando se haya editado el usuario, confirme que se ha hecho bien-->
        <?php if($result || $critical_error){ ?>
            <article class="message <?= $result ? 'is-success' : 'is-warning'?> " id="toast">
                <div class="message-header">
                    <?php if($result){ ?>
                        <p><?= $result ?></p>
                    <?php } else { ?>
                        <p><?= $critical_error ?>></p>
                    <?php } ?>
                    <button class="delete" aria-label="delete" onclick="document.getElementById('toast').remove()"></button>
                </div>
            </article>
        <?php } ?>
        <!-- Paginación -->
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
            <!-- Botones anterior/siguiente-->
            <?php if($page != 0){?>
                <a href="sub_thread.php?pag=<?= $page - 1 ?>&id-thread=<?= $thread_id ?>"
                   class="pagination-previous">Anterior</a>
            <?php }else {?>
                <button class="pagination-previous" disabled>Anterior</button>
            <?php } ?>
            <?php if(($page + 1) != $last_page){?>
                <a href="sub_thread.php?pag=<?= $page + 1 ?>&id-thread=<?= $thread_id ?>"
                   class="pagination-next">Siguiente</a>
            <?php }else {?>
                <button class="pagination-previous" disabled>Siguiente</button>
            <?php } ?>

            <!-- Botones con números-->
            <ul class="pagination-list">
                <li>
                    <a <?= $page != 0 ? 'href="sub_thread.php?pag=0&id-thread=' . $thread_id. '"' : ''?>
                        class="pagination-link <?= $page == 0 ? 'is-current' : ''?>" aria-label="Ir a página 1">1
                    </a>
                </li>
                <!-- ... -->
                <?php if($page > 2){ ?>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                <?php } ?>
                <!-- anterior al seleccionado -->
                <?php if($page >= 2){ ?>
                    <li><a href="sub_thread.php?pag=<?= $page - 1 ?>&id-thread=<?= $thread_id ?>"
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
                    <li><a href="sub_thread.php?pag=<?= $page + 1 ?>&id-thread=<?= $thread_id ?>"
                           class="pagination-link" aria-label="Ir a página <?= $page + 2 ?>"><?= $page + 2 ?></a>
                    </li>
                <?php } ?>
                <!-- ... -->
                <?php if(($page + 2) < ($last_page - 1)){ ?>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                <?php } ?>
                <!-- Último botón -->
                <?php if($last_page > 1){ ?>
                    <li>
                        <a <?= $page + 1 != $last_page ? 'href="sub_thread.php?pag='. ($last_page - 1) . '&id-thread=' . $thread_id. '"' : ''?>
                            class="pagination-link <?= $page + 1 == $last_page ? 'is-current' : ''?>"
                            aria-label="Ir a página "<?= $last_page ?>><?= $last_page ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <?php foreach ($sub_threads as $sub_thread){ ?>
            <div class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-64x64">
                                <img
                                    src="<?= $sub_thread['image_name'] != null ? "../../uploads/" . $sub_thread['image_name'] : "../assets/images/no_image.jpg"; ?>"
                                    alt="Avatar"
                                />
                            </figure>
                        </div>
                        <div class="media-content">
                            <p class="title is-4"><?= $sub_thread['username'] ?? 'Unknown' ?></p>
                            <p class="subtitle is-6"><?= ucfirst($sub_thread['role']) ?? 'User' ?></p>
                        </div>
                        <?php if(isset($user) &&  ($user['email'] === $sub_thread['author'] ||
                                strtolower($user['role']) === 'moderator' ||
                                strtolower($user['role']) === 'admin')){
                            ?>
                            <div class="media-right">
                                <div class="tags has-addons">
                                    <button id="btn-menu-edit-<?= $sub_thread['id'] ?>"
                                            class="tag is-link" onclick="changeEditionMode(<?= $sub_thread['id'] ?>)">
                                        Editar
                                    </button>
                                    <button type="button" id="btn-menu-delete-<?= $sub_thread['id'] ?>"
                                            class="button tag is-light is-danger js-modal-trigger"
                                            data-target="modal-delete-<?=$sub_thread['id']?>">Borrar
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Formulario de edición del mensaje -->
                    <div class="content">
                        <form class="user-form" action="../controller/SubThreadController.php" method="post">
                            <input type="hidden" name="sub_thread_id" value="<?= $sub_thread['id'] ?>" />
                            <input type="hidden" name="thread_id" value="<?= $sub_thread['thread_id'] ?>" />
                            <input type="hidden" name="page" value="<?= $page ?>" />
                            <div class="field">
                                <textarea id="edited-content-<?= $sub_thread['id'] ?>" name="edited-content" readonly
                                          class="textarea"> <?= $sub_thread['content'] ?? ''?>
                                </textarea>
                            </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <button id="btn-edit-<?= $sub_thread['id'] ?>"
                                            class="tag is-medium is-primary is-light is-hidden"
                                            name="action-sub-thread" value="edit-sub-thread" >Guardar cambios
                                    </button>
                                </div>
                                <div class="control">
                                    <button id="btn-cancel-<?= $sub_thread['id'] ?>"
                                            class="tag is-medium  is-light is-hidden is-link is-light"
                                            type="reset" hidden onclick="cancelEditionMode(<?= $sub_thread['id'] ?>)">Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="is-display-flex is-justify-content-space-between">
                            <time>Creado: <?= date_format(date_create($sub_thread['created_at']), $FORMAT_DATE) ?></time>
                            <time>Última edición: <?= date_format(date_create($sub_thread['updated_at']), $FORMAT_DATE) ?></time>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrar el sub thread -->
            <div id="modal-delete-<?= $sub_thread['id']?>" class="modal">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Borrar el mensaje</p>
                        <button class="delete" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                        <p class="is-danger">El mensaje se borrará, esta acción no se puede deshacer.</p>
                    </section>
                    <footer class="modal-card-foot">
                        <div class="buttons">
                            <a class="tag is-danger"
                               href="../controller/SubThreadController.php?action=delete-sub-thread&id-thread=<?= $thread_id ?>&id-sub-thread=<?= $sub_thread['id']?>"
                            >Borrar</a>
                            <button class="button tag is-link">Cancelar</button>
                        </div>
                    </footer>
                </div>
            </div>
        <?php } ?>

        <?php if($user !== null){ ?>
            <!-- Formulario para un nuevo thread-->
            <form action="../controller/SubThreadController.php" method="post" class="user-form box" id="new-sub-thread">
                <input class="input" type="hidden" name="author" id="author" value="<?= $user['email'] ?>">
                <input class="input" type="hidden" name="thread_id" id="thread_id" value="<?= $thread_id ?>">
                <input class="input" type="hidden" name="last_page" id="last_page" value="<?= $last_page != 0 ? $last_page - 1 : 0 ?>">
                <div class="field">
                    <label class="label" for="content">Mensaje</label>
                    <div class="control">
                        <textarea class="textarea textarea-min-height is-info" type="text" name="content" id="content"
                                  rows="8" cols="50" required></textarea>
                    </div>
                    <?php if(isset($errors['content'])){ ?>
                        <p class="help is-danger"><?= $errors['content'] ?></p>
                    <?php } ?>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" name="action-sub-thread" value="add-sub-thread">Nuevo mensaje</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light" type="reset">Limpiar</button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </main>
</body>
</html>
