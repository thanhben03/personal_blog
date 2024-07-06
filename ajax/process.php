<?php
require_once("../libs/db.php");
require_once("../libs/helper.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $db = new DB();
    $helper = new Helper();
    switch ($action) {
        case 'onPinned':
            $idPost = $_POST['idPost'];
            $checked = $_POST['checked'];
            // $sql = "UPDATE b_post VALUES (title,content,tags,status,created_time,updated_time,author_id) VALUES('$title','$content','$tags',$status,'$created','$updated',1)";

            $sql = "UPDATE b_post SET `hot` = $checked WHERE id = $idPost";
            $db->handleSQL($sql);
            die(json_encode([
                'status' => 'success',
                'msg' => 'Cập nhật thành công !'
            ]));

            break;
        case 'createPost':
            $title = trim($_POST['title']);
            $tags = trim($_POST['tags']);
            $category = trim($_POST['category']);
            $thumbnail = trim($_POST['thumbnail']);
            $status = trim($_POST['status']);
            $content = $_POST['content'];
            $created = $updated = date("Y-m-d H:i:s");
            $arrTags = explode(",", $_POST['tags']);
            $slug = create_slug($title);

            $sql = "INSERT INTO b_post (title,content,tags,status,created_time,updated_time,author_id,hot,slug,thumbnail) VALUES('$title','$content','$tags',$status,'$created','$updated',1,0,'$slug','$thumbnail')";
            // die($sql);
            $db->handleSQL($sql);

            $get_row_latest_post = $helper->getRowLatest('b_post'); //lấy dòng vừa mới insert
            $post_id_latest = $get_row_latest_post['id']; //lấy id vừa mới insert


            foreach ($arrTags as $item) {
                //Kiểm tra tags đã tồn tại trong csdl chưa
                if ($item != '') {
                    if (!checkExitsTag($item)) {
                        $sql = "INSERT INTO b_tags VALUES(null,'$item')";
                        $db->handleSQL($sql);
                    }
                    $get_tag = $db->getOneRowWithSQL("SELECT * FROM b_tags WHERE title = '$item'"); //lấy dòng vừa mới insert
                    $tag_id = $get_tag['id_tag']; //lấy id vừa mới insert
                    $sql = "INSERT INTO b_tag_of_post VALUE(null,$post_id_latest,$tag_id)";
                    $db->handleSQL($sql);
                }
            }
            if (!checkExitsCate($category)) {
                $sql = "INSERT INTO b_categories VALUES(null,'$category')";
                $db->handleSQL($sql);
            }
            $get_category = $db->getOneRowWithSQL("SELECT * FROM b_categories WHERE title = '$category'"); //lấy dòng vừa mới insert
            $cate_id = $get_category['id_cate']; //lấy id vừa mới insert
            $sql = "INSERT INTO b_cate_of_post VALUE(null,$cate_id,$post_id_latest)";
            $db->handleSQL($sql);
            die(json_encode([
                'status' => 'success',
                'msg' => 'Tạo bài viết thành công !'
            ]));
            break;
        case 'deletePost':
            $idpost = $_POST['idPost'];
            $sql = "DELETE FROM b_post WHERE id=$idpost";
            $db->handleSQL($sql);
            die(json_encode([
                'status' => 'success',
                'msg' => 'Xóa thành công !'
            ]));
        case 'postComment':
            $user_id = $_POST['account']['id'] ?? 2;
            $post_id = $_POST['post_id'];
            $message = $_POST['message'];
            $created_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO b_comment VALUES(null,'$message',1,null,$user_id,$post_id,'$created_time')";
            $db->handleSQL($sql);
            die(json_encode([
                'status' => 'success',
                'msg' => 'Bình luận thành công !',
                'sql' => $sql
            ]));
        default:
            # code...
            break;
    }
}


/**
 * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
 * @access    public
 * @param string
 * @return    string
 */
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
