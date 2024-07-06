    <?php
    $categories = $helper->getListCategoriesUsed();
    $randomPosts = $helper->getRandomRow('b_post', 3);
    $author = $db->getOneRowFromTable('b_author');
    if (isset($post_id)) {
        $sql = "SELECT * FROM b_tag_of_post a JOIN b_tags b ON a.tag_id = b.id_tag WHERE post_id = $post_id ";
    } else {
        $sql = "SELECT * FROM b_categories LIMIT 10";
    }

    $tags = $db->getList($sql) ?? [];

    // print_r($randomPosts);
    // die();
    ?>
    <div class="col-md-12 col-lg-4 sidebar">
        <div class="sidebar-box search-form-wrap">
            <form action="#" class="search-form" method="POST">
                <div class="form-group">
                    <span class="icon fa fa-search"></span>
                    <input type="text" class="form-control" id="keyword" name="key" placeholder="Type a keyword and hit enter">
                </div>
            </form>
        </div>
        <!-- END sidebar-box -->
        <div class="sidebar-box">
            <div class="bio text-center">
                <img src="<?= $helper->base_url('public/images/person_1.jpg') ?>" alt="Image Placeholder" class="img-fluid">
                <div class="bio-body">
                    <h2><?= $author['name'] ?></h2>
                    <p><?= $author['content'] ?>/p>
                    <p><a href="#" class="btn btn-primary btn-sm rounded">Read my bio</a></p>
                    <p class="social">
                        <a href="<?= $author['facebook'] ?>" class="p-2"><span class="fa fa-facebook"></span></a>
                        <a href="<?= $author['twitter'] ?>" class="p-2"><span class="fa fa-twitter"></span></a>
                        <a href="<?= $author['instagram'] ?>" class="p-2"><span class="fa fa-instagram"></span></a>
                        <a href="<?= $author['youtube'] ?>" class="p-2"><span class="fa fa-youtube-play"></span></a>
                    </p>
                </div>
            </div>
        </div>
        <!-- END sidebar-box -->
        <div class="sidebar-box">
            <h3 class="heading">Random Posts</h3>
            <div class="post-entry-sidebar">
                <ul>
                    <?php
                    foreach ($randomPosts as $item) {
                        echo '
                            <li>
                                <a href="/blog/' . $item['slug'] . '">
                                    <img src="' . $item['thumbnail'] . '" alt="Image placeholder" class="mr-4">
                                    <div class="text">
                                        <h4>' . $item['title'] . '</h4>
                                        <div class="post-meta">
                                            <span class="mr-2">' . $item['updated_time'] . '</span>
                                        </div>
                                    </div>
                                </a>
                            </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- END sidebar-box -->
        <div class="sidebar-box">
            <h3 class="heading">Categories</h3>
            <ul class="categories">
                <?php
                foreach ($categories as $item) {
                    echo '
                            <li><a href="#">' . $item['title'] . '<span>(' . $item['total'] . ')</span></a></li>
                        ';
                }
                ?>
                <!-- <li><a href="#">Travel <span>(22)</span></a></li>
                <li><a href="#">Lifestyle <span>(37)</span></a></li>
                <li><a href="#">Business <span>(42)</span></a></li>
                <li><a href="#">Adventure <span>(14)</span></a></li> -->
            </ul>
        </div>
        <!-- END sidebar-box -->
        <div class="sidebar-box">
            <h3 class="heading">Tags</h3>
            <ul class="tags">
                <?php
                foreach ($tags as $item) {
                    echo '
                        <li><a href="#">' . $item['title'] . '</a></li>
                        ';
                }
                ?>
            </ul>
        </div>
    </div>