<?php

require_once __DIR__ . "/../controller/ThreadController.php";
require_once __DIR__ . "/../controller/ThemeController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$theme_id = $_GET['id-theme'] ?? null;
if ($theme_id === null) {
    header("Location: main.php");
    exit();
}

$FORMAT_DATE = "d/m/Y H:i";
$LIMIT = 5;
$page = $_GET['pag'] ?? 0;
$response = ThreadController::getThreadsByTheme($theme_id, $LIMIT, $page * $LIMIT);
$total_registers = $response['count'] ?? 0;
$last_page = ceil($total_registers / $LIMIT);
$threads = $response['threads'] ?? [];
$theme_actual = ThemeController::getTheme($theme_id);

?>

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

<p><?= (is_array($theme_actual) && isset($theme_actual['name'])) ? $theme_actual['name'] : '' ?></p>
<main class="container">
    <!-- Paginación -->
    <nav class="pagination is-small" role="navigation" aria-label="pagination">
        <!-- Botones anterior/siguiente-->
        <?php if($page != 0){?>
            <a href="theme.php?pag=<?= $page - 1 ?>&id-theme=<?= $theme_id ?>"
               class="pagination-previous">Anterior</a>
        <?php }else {?>
            <button class="pagination-previous" disabled>Anterior</button>
        <?php } ?>
        <?php if(($page + 1) != $last_page){?>
            <a href="theme.php?pag=<?= $page + 1 ?>&id-theme=<?= $theme_id ?>"
               class="pagination-next">Siguiente</a>
        <?php }else {?>
            <button class="pagination-previous" disabled>Siguiente</button>
        <?php } ?>

        <!-- Botones con números-->
        <ul class="pagination-list">
            <li>
                <a <?= $page != 0 ? 'href="theme.php?pag=0&id-theme=' . $theme_id. '"' : ''?>
                   class="pagination-link <?= $page == 0 ? 'is-current' : ''?>" aria-label="Ir a página 1">1
                </a>
            </li>
            <!-- ... -->
            <?php if($page > 2){ ?>
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            <?php } ?>
            <!-- anterior al seleccionado -->
            <?php if($page > 1 && $page < $last_page){ ?>
                <li><a href="theme.php?pag=<?= $page ?>&id-theme=<?= $theme_id ?>" class="pagination-link" aria-label="Ir a página <?= $page ?>"><?= $page ?></a></li>
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
                <li><a href="theme.php?pag=<?= $page + 2 ?>&id-theme=<?= $theme_id ?>" class="pagination-link" aria-label="Ir a página <?= $page + 2 ?>"><?= $page + 2 ?></a></li>
            <?php } ?>
            <!-- ... -->
            <?php if(($page + 2) < ($last_page - 1)){ ?>
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            <?php } ?>
            <!-- Último botón -->
            <?php if($last_page > 1 ){ ?>
                <li>
                    <a <?= $page + 1 != $last_page ? 'href="theme.php?pag='. ($last_page - 1) . '&id-theme=' . $theme_id. '"' : ''?>
                       class="pagination-link <?= $page + 1 == $last_page ? 'is-current' : ''?>"
                       aria-label="Ir a página "<?= $last_page ?>><?= $last_page ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <?php foreach ($threads as $thread){ ?>
        <article class="message">
            <div class="message-header">
                <a href="thread.php?id-thread=<?= $thread['id'] ?>">
                    <p class="subtitle is-5"><?= $thread['title'] ?></p>
                </a>
            </div>
            <div class="message-body">
                <section class="level">
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Creado por</p>
                            <p class="subtitle is-5"><?= $thread['creator'] ?></p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Última actualización</p>
                            <p class="subtitle is-5"><?= date_format(date_create($thread['updated_at']), $FORMAT_DATE) ?></p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Último mensaje por</p>
                            <p class="subtitle is-5"><?= $thread['updater'] ?></p>
                        </div>
                    </div>
                </section>
            </div>
        </article>
    <?php } ?>
</main>
</body>
</html>

