<?php

require_once __DIR__ . "/../config/config_error.php";
require_once __DIR__ . '/../controller/ThemeController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Cerrar sesión
$mode = $_GET['mode'] ?? 'no_mode';
if($mode == 'close'){
    require_once __DIR__ . "/../util/destroy_session.php";
    header("Location: ../view/theme.php");
    exit();
}
$isLoggedIn = false;
if(!isset($_SESSION["user"])){
    $isLoggedIn = true;
}

//El navBar también hace lo mismo, doble seguro
if(!isset($_SESSION["themes"])){
    $_SESSION["themes"] = ThemeController::getAllThemes();
}
$themes = $_SESSION["themes"];

$banner_path = '../assets/images/banner/';

unset($_SESSION["breadcrumbs"]);

?>

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
    <h1 class="title is-1 has-text-centered">Foro cocina</h1>
    <main class="fixed-grid mt-6">
        <div class="grid">
            <?php foreach ($themes as $theme){ ?>
                <section class="mx-6 my-3 cell">
                    <a href="thread.php?pag=0&id-theme=<?= $theme['id'] ?>">
                        <p class="has-text-centered is-size-4"><?= $theme['name'] ?></p>
                        <figure id="container-banner" class="image is-3by1">
                            <img class=""
                                 src="<?= isset($theme['banner']) ? $banner_path . $theme['banner'] : $banner_path . "banner_default.png"; ?>"
                                 alt="<?= $theme['name'] . 'banner'?>"
                            />
                        </figure>
                    </a>
                    <p><?= $theme['description'] ?></p>
                </section>
            <?php } ?>
        </div>
    </main>
    <?php require_once __DIR__ . "/../components/footer.php"?>
</body>
</html>
