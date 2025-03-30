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
$LIMIT = 1;
$page = $_GET['page'] ?? 0;
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
<?php var_dump($threads); ?>
<body>
<header>
    <?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
</header>
<p><?= (is_array($theme_actual) && isset($theme_actual['name'])) ? $theme_actual['name'] : '' ?></p>
<main class="container">
    <!-- Paginación -->
    <nav class="pagination is-small" role="navigation" aria-label="pagination">
        <a href="theme.php?pag=<?= (($page - 1) < 0) ? 0 : $page - 1 ?>&id-theme=<?= $theme_id ?>"
           class="pagination-previous <?= $page === 0 ? 'is-disabled' : '' ?>"
        >
            Anterior
        </a>
        <a href="theme.php?pag=<?= (($page + 1) >= $last_page) ? $last_page : $page + 1 ?>&id-theme=<?= $theme_id ?>"
           class="pagination-next <?= $page ===  ($last_page - 1)? 'is-disabled' : '' ?>"
        >
            Siguiente
        </a>
        <ul class="pagination-list">
            <li><a href="#" class="pagination-link" aria-label="Goto page 1">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a href="#" class="pagination-link" aria-label="Goto page 45">45</a></li>
            <li>
                <a
                        class="pagination-link is-current"
                        aria-label="Page 46"
                        aria-current="page"
                >46</a
                >
            </li>
            <li><a href="#" class="pagination-link" aria-label="Goto page 47">47</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a href="#" class="pagination-link" aria-label="Goto page 86">86</a></li>
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

