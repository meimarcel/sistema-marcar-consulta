<?php 
function __autoload($class_name)
{
    $directorys = array(
        'controller/',
        'model/',
        'views/',
        'utils/',
        'public/',
        ''
    );
    $extencaos = array(
        '../',
        '../../',
        '../../../',
        './',
        ''
    );

    foreach ($extencaos as $extencao) {
        foreach ($directorys as $directory) {
            if (file_exists($extencao . $directory . $class_name . '.php')) {
                require_once($extencao . $directory . $class_name . '.php');
                return;
            }
            if (file_exists($extencao . $directory . $class_name . '.inc.php')) {
                require_once($extencao . $directory . $class_name . '.inc.php');
                return;
            }
        }
    }
}


?>