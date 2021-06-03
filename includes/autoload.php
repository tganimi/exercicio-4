<?php
define('BASE_PATH', realpath(dirname(__FILE__)));

/**
 * @param $className
 * @return bool
 */
function autoloader($className) {

    $extension = ".php";
    $fileName = dirname(__DIR__) . '/classes/'. $className . $extension;
    require_once($fileName);
}

spl_autoload_register('autoloader');
