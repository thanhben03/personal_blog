<?php
$body = [
    'title' => 'Chỉnh sửa bài viết'
];
require_once(__DIR__ . '/header.php');
if (isset($_GET['id'])) {
    $idPost = $_GET['id'];
    // $sql = "SELECT * FROM b_post WHERE id= $idPost";
    $data = $db->getOneRow('b_post', $idPost);
    $category = $helper->getCategorysByIdPost($idPost);
}
?>
<div class="content-page">
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bài Viết Blog</h4>
                    <form action="process.php" id="form-submit-edit" name="form-create-post" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Chủ đề:</label>
                            <input type="text" value="<?= $data['title'] ?>" id="title" name="title" class="form-control">
                            <input type="text" value="update" id="title" name="type" hidden class="form-control">
                            <input type="text" value="<?= $data['id'] ?>" id="idPost" name="idPost" hidden class="form-control">
                        </div>
                        <div class="row col-12">
                            <div class="col-6 mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail:</label>
                                <input type="text" id="thumbnail" value="<?=$data['thumbnail']?>" name="thumbnail" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <select type="text" id="category" name="category" class="form-control">
                                    <?php
                                        foreach ($category as $item) {
                                            echo '
                                                <option selected value="'.$item['title'].'">'.$item['title'].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags:</label>
                            <select type="text" id="tags" name="tags" class="form-control">
                                <!-- <option value="1">123</option> -->
                                <!-- <option selected value="2">234</option>
                                <option selected value="2">234</option>
                                <option selected value="2">234</option>
                                <option selected value="2">234</option> -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Thời gian tạo:</label>
                            <input readonly value="<?= $data['created_time'] ?>" type="datetime" id="tags" name="created_time" class="form-control" placeholder="Các thẻ...">
                        </div>
                        <?php
                        $checked1 = $checked2 = '';
                        if ($data['status'] == 1) {
                            $checked1 = 'checked';
                        } else {
                            $checked2 = 'checked';
                        }
                        echo '
                                <div class="mb-3">
                                    <label for="customRadiocolor1" class="form-label">Công khai</label>
                                    <input type="radio" id="customRadiocolor1" name="status" value="1" class="" ' . $checked1 . '>
                                    <label for="customRadiocolor2" class="form-label">Nháp</label>
                                    <input type="radio" id="customRadiocolor2" name="status" value="2" class="" ' . $checked2 . '>
                                </div>
                                ';
                        ?>


                        <div class="mb-3">
                            <label for="example-textarea" class="form-label">Text area</label>
                            <textarea class="form-control" name="content" id="editor" rows="10"><?= $data['content'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- End Content -->


</div>
<?php
require_once(__DIR__ . '/footer.php');
?>
<script>
    tinymce.init({
        selector: 'textarea#editor',
        height: 500,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
<script>
    $(document).ready(function() {
        $('#form-submit-edit').submit(function(event) {
            event.preventDefault(); // <- avoid reloading
            var tags = $('#tags').select2('data');
            let a = '';
            tags.forEach(tag => {
                a += tag.text + ",";
            });
            var categories = $("#category").val();
            tinyMCE.triggerSave();

            $.ajax({
                type: "POST",
                url: "<?= $helper->base_url('ajax/HandleEditPost.php') ?>",
                data: $(this).serialize() + "&tags=" + a + "&category="+categories,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        toastr.success(response.msg, 'success!');
                    } else {
                        alert("Đã xảy ra lỗi !!!");
                    }
                    // window.location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });

        });
        $('#tags').select2({
            tags: true,
            multiple: true,
            ajax: {
                url: "<?= $helper->base_url('ajax/getTags.php') ?>",
                data: function(params) {
                    var queryParam = {
                        q: params.term
                    }

                    return queryParam;
                },
                dataType: "json",
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.title,
                                id: item.id_tag
                            }
                        })
                    }
                }

            }
        });
        $('#category').select2({
            tags: true,
            ajax: {
                url: "<?= $helper->base_url('ajax/getCategories.php') ?>",
                data: function(params) {
                    var queryParam = {
                        q: params.term
                    }

                    return queryParam;
                },
                dataType: "json",
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.title,
                                id: item.id_cate
                            }
                        })
                    }
                }

            }
        });
        $.ajax({
            type: "POST",
            url: "<?= $helper->base_url('ajax/getTags.php') ?>",
            data: {
                post_id: <?= $idPost ?>
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $.each(response, function(index, tag) {
                    $("#tags").append(`<option selected value='${tag.title}'>${tag.title}</option>`)
                });
            }
        });
    });
</script>