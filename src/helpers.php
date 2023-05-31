<?php

if (!function_exists('config')) {
    function config(string $key, mixed $value)
    {
        var_dump(4444444444);
        $adr = require_once __DIR__ . "/../config/esb.php";
        var_dump($adr);
        die();
    }
}
