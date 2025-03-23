<?php

use controller\DatabaseController;

require_once "controller/DatabaseController.php";


$messages = (new DatabaseController())->dbConnect();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
</head>

<body>
<?php
if (is_array($messages)) {
    foreach ($messages as $message) {
        echo $message . "<br>";
    }
} else if(is_string($messages))
    echo $messages . "<br>";
header("Location: view/login.php?mode=login");
exit();
?>
</body>

</html>
