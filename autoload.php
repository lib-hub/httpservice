<?php
/**
 * Created by PhpStorm.
 * User: antrouflias
 * Date: 23/12/2019
 * Time: 15:51
 */

/**
 * Autoload composer libs
 */
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}
/**
 * Autoload project
 */
spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    if (file_exists($className . '.php')) {
        require_once($className . '.php');
        return true;
    }
    return false;
});
