<?php
$body = [
    'title' => 'Chỉnh sửa tác giả'
];
$author = $helper->getAuthor();
require_once(__DIR__ . '/header.php');
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
                    <form action="#" method="POST" id="form-update-author">
                        <div class="row">
                            <div class="mb-3 col-sm-6">
                                <label for="title" class="form-label">Avatar:</label><span>(Sử dụng link để cập nhật avatar)</span>
                                <input type="text" id="title" placeholder="Nhập vào link ảnh" name="avatar" value="<?= $author['avatar'] ?>" class="form-control">
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control" value="<?= $author['name'] ?>" id="name">
                                <!-- <input type="text" id="tags" name="tags" class="form-control" placeholder="Các thẻ..."> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-3">
                                <label for="title" class="form-label">Facebok:</label>
                                <input type="text" id="facebook" name="facebook" value="<?= $author['facebook'] ?>" class="form-control">
                            </div>
                            <div class="mb-3 col-sm-3">
                                <label for="title" class="form-label">Twitter:</label>
                                <input type="text" id="twitter" name="twitter" value="<?= $author['twitter'] ?>" class="form-control">
                            </div>
                            <div class="mb-3 col-sm-3">
                                <label for="title" class="form-label">Instagram:</label>
                                <input type="text" id="instagram" name="instagram" value="<?= $author['instagram'] ?>" class="form-control">
                            </div>
                            <div class="mb-3 col-sm-3">
                                <label for="title" class="form-label">Youtube:</label>
                                <input type="text" id="youtube" name="youtube" value="<?= $author['youtube'] ?>" class="form-control">
                            </div>
                        </div>


                        <button class="btn btn-info">Chỉnh sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

</div> <!-- End Content -->


<?php
require_once(__DIR__ . '/footer.php');
?>

<script>
    $("#form-update-author").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= $helper->base_url('ajax/updateAuthor.php') ?>",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status == 'success') {
                    toastr.success(response.msg,'success!');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            }
        });
    })
</script>