<?php

set_include_path(implode(PATH_SEPARATOR, array (
    __DIR__ . '/../src',
    __DIR__ . '/unit',
    __DIR__ . '/functional',
    get_include_path(),
)));

spl_autoload_register(function ($class) {
    $path = str_replace(array ('_', '\\'), DIRECTORY_SEPARATOR, $class) . '.php';
    @include $path;
});
