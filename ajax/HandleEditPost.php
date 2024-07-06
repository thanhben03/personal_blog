<?php
require_once("../libs/db.php");
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPost = $_POST['idPost'];
    $title = trim($_POST['title']);
    $tags = trim($_POST['tags']);
    $arrTags = explode(",", $tags);
    $thumbnail = trim($_POST['thumbnail']);
    $category = trim($_POST['category']);

    $status = trim($_POST['status']);
    $content = trim($_POST['content']);
    $updated = date("Y-m-d H:i:s");
    $slug = create_slug($title);
    $sql = "UPDATE b_post SET `title` = '$title', `content` = '$content', `tags` = '$tags', `status` = $status, `updated_time` = '$updated',`slug` = '$slug', `thumbnail` = '$thumbnail' WHERE id = $idPost";
    // $arrTags = array_pop($arrTags);
    unset($arrTags[count($arrTags) - 1]);
    $db->handleSQL($sql);
    $sql = "DELETE FROM b_tag_of_post WHERE post_id = $idPost ";
    $db->handleSQL($sql);
    $sql = "DELETE FROM b_cate_of_post WHERE post_id = $idPost ";
    $db->handleSQL($sql);
    insertTag($arrTags, $idPost);
    if (!checkExitsCate($category)) {
        $sql = "INSERT INTO b_categories VALUES(null,'$category')";
        $db->handleSQL($sql);
    }
    $get_category = $db->getOneRowWithSQL("SELECT * FROM b_categories WHERE title = '$category'"); //lấy dòng vừa mới insert
    $cate_id = $get_category['id_cate']; //lấy id vừa mới insert
    $sql = "INSERT INTO b_cate_of_post VALUE(null,$cate_id,$idPost)";
    $db->handleSQL($sql);
    // echo $sql;
    die(json_encode([
        'status' => 'success',
        'msg' => 'Cập nhật thành công !'
    ]));
}

function create_slug($string)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);
    return $string;
}

function insertTag($arrTags, $idPost)
{
    $db = new DB();

    foreach ($arrTags as $item) {
        //Kiểm tra tags đã tồn tại trong csdl chưa
        if ($item != '') {
            if (!checkExitsTag($item)) {
                $sql = "INSERT INTO b_tags VALUES(null,'$item')";
                $db->handleSQL($sql);
            }
            $get_tag = $db->getOneRowWithSQL("SELECT * FROM b_tags WHERE title = '$item'"); //lấy dòng vừa mới insert
            $tag_id = $get_tag['id_tag']; //lấy id vừa mới insert
            $sql = "INSERT INTO b_tag_of_post VALUE(null,$idPost,$tag_id)";
            $db->handleSQL($sql);
        }
    }
}


function checkExitsTag($item)
{
    $db = new DB();
    return $db->checkExistsRow("SELECT title FROM b_tags WHERE title = '$item'");
}


function checkExitsCate($item)
{
    $db = new DB();
    return $db->checkExistsRow("SELECT title FROM b_categories WHERE title = '$item'");
}
