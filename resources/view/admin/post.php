<?php
$body = [
    'title' => 'Danh Sách Các Bài Viết'
];
require_once(__DIR__ . '/header.php');
$sql = "SELECT * FROM b_post";
// $help = new Helper();
$posts = $db->getList($sql);
?>
<div class="content-page">
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/admin/create">Create</a></li>
                            <!-- <li class="breadcrumb-item"><a href="">Pages</a></li> -->
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bài Viết Blog</h4>
                    <table class="table table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Pinned</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($posts as $post) {
                                $pinned = $post['hot'] == 1 ? 'checked' : '';
                                echo '
                                        <tr>
                                            <td>' . $post['title'] . '</td>
                                            <td><img src="' . $post['thumbnail'] . '" style="width: 50px"></td>
                                            <td>' . $post['status'] . '</td>
                                            <td>
                                            <div>
                                                <input class="btnOnPinned" data-idpost=' . $post['id'] . '  type="checkbox" id="switch' . $post['id'] . '" ' . $pinned . ' data-switch="success" />
                                                <label for="switch' . $post['id'] . '" data-on-label="Yes" data-off-label="No" class="mb-0 d-block">
                                            </label>
                                        </div>
                                            </td>
                                            <td>
                                                <a class="btnEditPost" href="/admin/edit/' . $post['id'] . '">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a class="btnDeletePost" data-idPost=' . $post['id'] . '>
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        ';
                            }
                            ?>
                            <!-- <tr>
                                    <td>Risa D. Pearson</td>
                                    <td>336-508-2157</td>
                                    <td>July 24, 1950</td>
                                    <td>
                                        <div>
                                            <input type="checkbox" id="switch1" checked data-switch="success" />
                                            <label for="switch1" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                        </div>
                                    </td>
                                </tr> -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- End Content -->

    <?php
    require_once(__DIR__ . '/footer.php');
    ?>
    <script>
        var btnDeletePosts = document.querySelectorAll(".btnDeletePost");
        var btnOnPinned = document.querySelectorAll(".btnOnPinned");
        btnDeletePosts.forEach(element => {
            element.onclick = function() {
                // console.log('123');
                deletePost(element.dataset.idpost);
            }
        });

        function deletePost(id) {
            var check = confirm("Bạn có chắc chắn muốn xóa ?");
            if (!check) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "<?=$helper->base_url('ajax/process.php')?>",
                data: {
                    action: 'deletePost',
                    idPost: id
                },
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    if (res.status == 'success') {
                        toastr.success(res.msg,'success!')
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }

        btnOnPinned.forEach(ele => {
            ele.onclick = function() {
                let idPost = ele.dataset.idpost;
                let checked = ele.checked ? 1 : 0;
                onPinned(idPost, checked);
            }
        });

        function onPinned(idPost, checked) {
            // console.log(id);
            $.ajax({
                type: "POST",
                url: "<?=$helper->base_url('ajax/process.php')?>",
                data: {
                    action: 'onPinned',
                    idPost: idPost,
                    checked: checked
                },
                dataType: "json",
                success: function(res) {
                    if (res.status == 'success') {
                        console.log('123');
                        toastr.success(res.msg,'success');
                    }
                }
            });
        }
    </script>