<?php

use controller\DatabaseController;

require_once "controller/DatabaseController.php";


$messages = (new DatabaseController())->dbConnect();
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
//header("Location: view/login.php?mode=login");
header("Location: view/main.php");
exit();
?>
</body>

</html>
