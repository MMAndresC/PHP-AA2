<?php

require_once __DIR__ . "/../controller/ThemeController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["themes"])){
    $_SESSION["themes"] = ThemeController::getAllThemes();
}

$themes = $_SESSION["themes"];

$isLoggedIn = false;
if(isset($_SESSION["user"])){
   $isLoggedIn = true;
}

//Para saber que theme está seleccionado, ya que no le llega el $_GET
$id_selected = -1;
$url = $_SERVER['REQUEST_URI'];
$position = strpos($url, "id-theme=");
if($position !== false && str_contains($url, "id-theme=")){
    $id_selected = (int) substr($url, $position + 9); // id-theme= tiene 9 caracteres, asi que hay que coger pos + 10
}

?>

<script type="text/javascript">
    <?php require_once __DIR__ . "/../scripts/navBarScript.js"; ?>
</script>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="">
            <?php require_once __DIR__ . "/../assets/images/logo/logo.svg"; ?>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMain">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarMain" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Reglas de uso
            </a>
            <?php if($isLoggedIn){ ?>
                <a class="navbar-item" href="../controller/UserPanelController.php">
                    Zona de Usuario
                </a>
            <?php } ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Foros
                </a>

                <div class="navbar-dropdown">
                    <?php foreach($themes as $theme){ ?>
                        <a class="navbar-item <?= $theme['id'] == $id_selected ? 'is-selected' : ''; ?>"
                           href="../view/thread.php?pag=0&id-theme=<?= $theme['id']; ?>"
                        >
                            <?= $theme['name']; ?>
                        </a>
                        <hr class="navbar-divider">
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if($isLoggedIn){ ?>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-light" href="../view/theme.php?mode=close">
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="../view/login.php?mode=register">
                                <strong>Registrarse</strong>
                            </a>
                            <a class="button is-light" href="../view/login.php?mode=login">
                                Iniciar sesión
                            </a>
                        </div>
                    </div>
                </div>
        <?php } ?>

    </div>
</nav>
