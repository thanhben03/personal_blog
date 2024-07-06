<?php
$body = [
    'title' => 'Xem Bài Viết'
];
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT * FROM b_post WHERE slug = '$slug'";
    $data = $db->getOneRowWithSQL($sql);
    $post_id = $data['id'];
    $categories = $helper->getListCategoriesByPost($post_id);
    $categories = $helper->convertCategoriesToString($categories);
    $sql = "SELECT * FROM b_comment cmt JOIN b_user u ON cmt.user_id = u.id WHERE cmt.post_id = $post_id";
    $comments = $db->getList($sql);
    $total = $db->getCountOfTable('b_comment', 'post_id = ' . $post_id . '');

}

// return;
?>

<div class="wrap">
    <?php
    require_once(__DIR__ . '/header.php');

    ?>
    <!-- END header -->

    <section class="site-section py-lg">
        <div class="container">

            <div class="row blog-entries element-animate">

                <div class="col-md-12 col-lg-8 main-content">
                    <img src="<?= $data['thumbnail'] ?>" alt="Image" class="img-fluid mb-5">
                    <div class="post-meta">
                        <span class="author mr-2"><img src="<?= $helper->base_url('public/images/person_1.jpg') ?>" alt="Colorlib" class="mr-2"> Colorlib</span>&bullet;
                        <span class="mr-2"><?= $data['updated_time'] ?></span> &bullet;
                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                    </div>
                    <h1 class="mb-4"><?= $data['title'] ?></h1>

                    <div class="post-content-body">
                        <?= $data['content'] ?>
                    </div>


                    <div class="pt-5">
                        <p>Categories 123:
                            <?= $categories ?>
                        </p>
                    </div>


                    <div class="pt-5">
                        <h3 class="mb-5"><?= $total['total'] ?> Comments</h3>
                        <ul class="comment-list">
                            <?php
                            foreach ($comments as $item) {
                                $avatar = $item['image'] ?? 'https://www.croptecshow.com/wp-content/uploads/2017/04/guest-avatar-250x250px.png';
                                echo '
                                    <li class="comment">
                                        <div class="vcard">
                                            <img src="'.$avatar.'" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">
                                            <h3>' . $item['username'] . '</h3>
                                            <div class="meta">' . $item['created_time'] . '</div>
                                            <p>' . $item['content'] . '</p>
                                            <p><a href="#" class="reply rounded">Reply</a></p>
                                        </div>
                                    </li>';
                            }
                            ?>
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5">
                            <h3 class="mb-5">Leave a comment</h3>
                            <div class="p-5 bg-light">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text" class="form-control" disabled value="Khách" id="name">
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" onclick=postComment() value="Post Comment" class="btn btn-primary btnPostComment">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- END main-content -->
                <?php
                require_once(__DIR__ . '/sidebar.php');
                ?>


            </div>
        </div>
    </section>

    <!-- <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3 ">Related Post</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="a-block sm d-flex align-items-center height-md" style="background-image: url('images/img_2.jpg'); ">
                        <div class="text">
                            <div class="post-meta">
                                <span class="category">Lifestyle</span>
                                <span class="mr-2">March 15, 2018 </span> &bullet;
                                <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                            </div>
                            <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="a-block sm d-flex align-items-center height-md" style="background-image: url('images/img_3.jpg'); ">
                        <div class="text">
                            <div class="post-meta">
                                <span class="category">Travel</span>
                                <span class="mr-2">March 15, 2018 </span> &bullet;
                                <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                            </div>
                            <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="a-block sm d-flex align-items-center height-md" style="background-image: url('images/img_4.jpg'); ">
                        <div class="text">
                            <div class="post-meta">
                                <span class="category">Food</span>
                                <span class="mr-2">March 15, 2018 </span> &bullet;
                                <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                            </div>
                            <h3>There’s a Cool New Way for Men to Wear Socks and Sandals</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>


    </section> -->
    <!-- END section -->
    <?php
    require_once(__DIR__ . '/footer.php');
    ?>
    <script>
        moment.locale('vi');
        var date = '2022-12-20';
        console.log(moment(date).format('LLLL'));

        async function postComment() {
            var data = {
                url: "<?= $helper->base_url('ajax/process.php') ?>",
                data: {
                    action: "postComment",
                    post_id: <?= $post_id ?>,
                    name: $("#name").val(),
                    message: $("#message").val()
                }
            }

            let res = await handleSendAjax(data);
            if (res.status == 'success') {
                toastr.success(res.msg,'success!');
                reloadPage(1500);
            }
        }

        function handleSendAjax(data) {
            return $.ajax({
                type: "POST",
                url: data.url,
                data: data.data,
                dataType: "json"
            });
        }

        function reloadPage(timeout) {
            setTimeout(() => {
                location.reload()
            }, timeout);
        }
    </script>