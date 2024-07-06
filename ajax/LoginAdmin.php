<?php
session_start();
require_once("../libs/db.php");
$db = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($db->checkAdmin($username,$password)) {
        $_SESSION['account']['username'] = $username;
        $_SESSION['account']['isAdmin'] = 1;
        die(json_encode([
            'status' => 'success',
            'msg' => 'Đăng nhập thành công !'
        ]));
    } else {
        die(json_encode([
            'status' => 'error',
            'msg' => 'Sai tên tài khoản hoặc mật khẩu!'
        ]));
    }
}