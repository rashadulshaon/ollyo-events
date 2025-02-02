<?php

require_once __DIR__ . '/vendor/autoload.php';

(new App\Kernel());

if (!function_exists('dump_and_die')) {
    function dump_and_die(...$vars)
    {
        header('Content-Type: text/html');

        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }

        exit;
    }
}
