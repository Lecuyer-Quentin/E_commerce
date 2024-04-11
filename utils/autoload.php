<?php

// Autoload classes
spl_autoload_register(function($class){
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../models/' . $class . '.php';
});
