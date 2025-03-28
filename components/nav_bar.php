<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = false;
if(isset($_SESSION["user"])){
   $isLoggedIn = true;

}?>

<script type="text/javascript">
    <?php require_once "../scripts/navBarScript.js"; ?>
</script>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="">
            <?php require_once("../assets/images/logo/logo.svg"); ?>
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
                    More
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        About
                    </a>
                    <a class="navbar-item is-selected">
                        Jobs
                    </a>
                    <a class="navbar-item">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        Report an issue
                    </a>
                </div>
            </div>
        </div>

        <?php if($isLoggedIn){ ?>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-light" href="../view/main.php?mode=close">
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
