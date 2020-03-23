<?php 
require_once "config/autoload.php";
session_start();

$classe = '';
$metodo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classe = $_POST['classe'];
    $metodo  = $_POST['metodo'];
} else {
    if(!isset($_GET['classe'])) {
        $classe = "Home";
        $metodo = "index";
    } else {
        $classe = $_GET['classe'];
        $metodo  = $_GET['metodo'];
    }
}
$classe = $classe."Controller";
// require_once "controller/".$classe.".php";

$controller = new $classe();
$controller->$metodo();


?>