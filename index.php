<?php
require_once "controller/database_controller.php";


$messages = (new \controller\DatabaseController())->dbConnect();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css/estilos.css">

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
} else {
    // Si no es array, imprimir directamente
    echo $messages . "<br>";
}
?>
</body>

</html>
