<?php

require_once __DIR__ . "/../controller/SubThreadController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$thread_id = $_GET['id-thread'] ?? null;
//TODO llevar a una vista de error
if ($thread_id === null) {
    header("Location: theme.php");
    exit();
}

$FORMAT_DATE = "h:iA - d M, Y ";
$LIMIT = 5;
$page = $_GET['pag'] ?? 0;
$response = SubThreadController::getSubThreadsData($thread_id, $LIMIT, $page * $LIMIT);
$total_registers = $response['count'] ?? 0;
$last_page = ceil($total_registers / $LIMIT);
$sub_threads = $response['sub_threads'] ?? [];

$user = $_SESSION['user'] ?? null;

$result = $_SESSION['result'] ?? false;
$critical_error = $_SESSION['critical_error'] ?? false;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>
<h1><?= var_dump($sub_threads) ?></h1>
<body>
    <header>
        <?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
    </header>
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
                <?php if($page > 1 && $page < $last_page){ ?>
                    <li><a href="sub_thread.php?pag=<?= $page ?>&id-thread=<?= $thread_id ?>"
                           class="pagination-link" aria-label="Ir a página <?= $page ?>"><?= $page ?></a>
                    </li>
                <?php } ?>
                <!-- seleccionado -->
                <?php if($page > 0 && $page + 1 < $last_page){ ?>
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
                    <li><a href="sub_thread.php?pag=<?= $page + 2 ?>&id-thread=<?= $thread_id ?>"
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
                    </div>

                    <div class="content">
                        <?= $sub_thread['content'] ?? ''?>
                        <br><br>
                        <div class="is-display-flex is-justify-content-space-between">
                            <time>Creado: <?= date_format(date_create($sub_thread['created_at']), $FORMAT_DATE) ?></time>
                            <time>Última edición: <?= date_format(date_create($sub_thread['updated_at']), $FORMAT_DATE) ?></time>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if($user !== null){ ?>
            <!-- Formulario para un nuevo thread-->
            <form action="../controller/ThreadController.php" method="post" class="user-form box" id="new-thread">
                <input class="input" type="hidden" name="author" id="author" value="<?= $user['email'] ?>">
                <input class="input" type="hidden" name="theme_id" id="theme_id" value="<?= $thread_id ?>">
                <input class="input" type="hidden" name="action" id="action" value="add">
                <div class="field">
                    <label class="label" for="content">Mensaje</label>
                    <div class="control">
                        <textarea class="input textarea-min-height" type="text" name="content" id="content"
                                  rows="8" cols="50" required></textarea>
                    </div>
                    <?php if(isset($errors['content'])){ ?>
                        <p class="help is-danger"><?= $errors['content'] ?></p>
                    <?php } ?>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Nuevo mensaje</button>
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
</body>
</html>
