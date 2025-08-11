<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/Models/{$class}.class.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Arquivo da classe {$class} não encontrado.");
    }
});