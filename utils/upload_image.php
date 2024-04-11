<?php
require_once 'error_message.php';

function upload_image($image, $path){
    $target_dir = $path;
    $target_file = $target_dir . basename($image["name"]);
    if(!move_uploaded_file($image["tmp_name"], $target_file)) {
        throw new Exception('Error[UPLOAD_IMAGE]');
    }
    return $target_file;
}
    