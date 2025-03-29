<?php

use controller\DatabaseController;

require_once "controller/DatabaseController.php";
require_once "controller/ThemeController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$messages = (new DatabaseController())->dbConnect();
$_SESSION["themes"] = ThemeController::getAllThemes();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css/index.css">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
<?php
if (is_array($messages)) {
    foreach ($messages as $message) {
        echo $message . "<br>";
    }
} else if(is_string($messages))
    echo $messages . "<br>";
header("Location: view/main.php");
exit();
?>
</body>

</html>
