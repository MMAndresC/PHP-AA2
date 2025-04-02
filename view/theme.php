<?php

require_once __DIR__ . "/../config/config.php";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <?php require_once __DIR__ . "/../components/nav_bar.php"; ?>
    </header>
    <main class="container mt-6">
        <?php foreach ($themes as $theme){ ?>
            <section class="box themes-section">
                <a href="thread.php?pag=0&id-theme=<?= $theme['id'] ?>">
                    <p class="has-text-centered is-size-4"><?= $theme['name'] ?></p>
                    <figure class="image is-2by1">
                        <img class=""
                             src="<?= isset($theme['banner']) ? $banner_path . $theme['banner'] : $banner_path . "banner_default.png"; ?>"
                             alt="<?= $theme['name'] . 'banner'?>"
                        />
                    </figure>
                </a>
                <p><?= $theme['description'] ?></p>
            </section>
        <?php } ?>
    </main>
    <?php require_once __DIR__ . "/../components/footer.php"?>
</body>
</html>
