<?php
require_once("../libs/db.php");
require_once("../libs/helper.php");
if ($_SERVER['REQUEST_METHOD']  == 'POST') {
    $db = new DB();
    $avatar = $_POST['avatar'];
    $name = $_POST['name'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $youtube = $_POST['youtube'];
    
    $sql = "UPDATE b_author SET `avatar` = '$avatar', `name` = '$name', `facebook` = '$facebook', `twitter` = '$twitter', `instagram` = '$instagram', `youtube` = '$youtube'";
    $db->handleSQL($sql);
    die(json_encode([
        'status' => 'success',
        'msg' => 'Chỉnh sửa thành công !'
    ]));
}

?>