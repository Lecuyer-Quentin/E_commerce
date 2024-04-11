<?php
function get_JSON($file_path, $name, $sub) {
    $data = json_decode(file_get_contents($file_path), true);
    if (isset($data[$name][$sub])) {
        return $data[$name][$sub];
    } else {
        return null;
    }
}