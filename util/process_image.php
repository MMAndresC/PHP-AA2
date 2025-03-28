<?php

function process_image($image): string
{
    //Nombre original del archivo
    $image_name = $image["name"];
    //Nombre con el que se ha almacenado en el servidor temporal después de subirlo
    $image_tmp = $image["tmp_name"];
    //La imagen por defecto no se guarda
    if($image_name === "no_image.jpg") return '';

    // Si no tiene extensión de imagén, se descarta
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_ext, $allowed_extensions)) return '';

    //Renombrar imagén
    $new_image_name = uniqid("img_", true) . "." . $image_ext;
    //Ruta desde el directorio que llama a esta función
    $upload_dir = "../../uploads/";
    $image_path = $upload_dir . $new_image_name;

    //Crear el directorio si no existe
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 777, true);
    }

    //Guardar la imagén temporal del servidor al directorio de uploads con el nuevo nombre
    $result = move_uploaded_file($image_tmp, $image_path);
    if(!$result) return '';

    //Devolver el nuevo nombre de la imagén que se guarda con los datos de usuario
    return $new_image_name;
}

function deleteImage($image_name) : void
{
    $image_path = "../../uploads/" . $image_name;
    unlink($image_path);
}