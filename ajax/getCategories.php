<?php
require_once("../libs/db.php");
require_once("../libs/helper.php");
$db = new DB();
$helper = new Helper();

if (isset($_GET['q'])) {
    $q = $_GET['q'] ?? '';
    $sql = "SELECT * FROM b_categories WHERE title LIKE '%$q%'";
    $tags = $db->getList($sql);

    die(json_encode($tags));
}


if (isset($_SERVER['REQUEST_METHOD']) == 'POST') {
    $post_id = $_POST['post_id'];
    $data = $helper->getTagsByIdPost($post_id);
    die(json_encode($data));
}

?>
