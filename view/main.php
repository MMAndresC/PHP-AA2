<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mode = $_GET['mode'] ?? 'no_mode';
if($mode == 'close'){
    require_once __DIR__ . "/../util/destroy_session.php";
    header("Location: ../view/main.php");
    exit();
}
$isLoggedIn = false;
if(!isset($_SESSION["user"])){
    $isLoggedIn = true;
}

$themes = $_SESSION["themes"];

$banner_path = '../assets/images/banner/';

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
<main class="container">
    <?php foreach ($themes as $theme){ ?>
        <section class="box themes-section">
            <a href="theme.php?pag=0&id-theme=<?= $theme['id'] ?>">
                <p class="has-text-centered is-size-3"><?= $theme['name'] ?></p>
                <figure class="image image is-2by1">
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
</body>
</html>
