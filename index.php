<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// if (empty($_SESSION['account'])) {
//     header("Location: login.php");
// }


if (isset($_SESSION['account'])) {
    $username = $_SESSION['account']['username'];
}
require_once(__DIR__.'/libs/db.php');
require_once(__DIR__.'/libs/helper.php');
$db = new DB();
$helper = new Helper();
$view = isset($_GET['view']) ? $_GET['view'] : 'client';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$path = 'resources/view/'.$view.'/'.$action.'.php';

if (file_exists($path)) {
    require_once(__DIR__.'/'.$path);
} else {
    require_once(__DIR__.'/resources/view/client/404.php');
}

?>