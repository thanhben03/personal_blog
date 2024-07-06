<?php
$body = [
    'title' => 'Tìm Kiếm Bài Viết'
];
$keyword = $_GET['key'] ?? '';


// Xử lý phân trang
$sql = "SELECT COUNT(*) as total FROM b_post WHERE `slug` LIKE '%$keyword%'";
$total_row = $db->getCountRow($sql);
$limit = 5;
$current_page = $_GET['page'] ?? 1;

$total_page = ceil($total_row / $limit);

$start = ($current_page - 1) * $limit;

if ($current_page > $total_page) {
    $current_page = $total_page;
} else if ($current_page < 1) {
    $current_page = 1;
}
$sql = "SELECT * FROM b_post WHERE `slug` LIKE '%$keyword%' LIMIT $start,$limit";
$blogs = $db->getList($sql);




require_once(__DIR__ . '/header.php');
require_once(__DIR__ . '/hot_topic.php');

?>

<section class="site-section py-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Latest Posts</h2>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="row">
                    <?php
                    foreach ($blogs as $blog) {
                        // print_r($blog); die();
                        echo '<div class="col-md-6">
                  <a href="/blog/' . $blog['slug'] . '" class="blog-entry element-animate" data-animate-effect="fadeIn">
                    <img src="' . $blog['thumbnail'] . '" alt="Image placeholder">
                    <div class="blog-content-body">
                      <div class="post-meta">
                        <span class="author mr-2"><img src="' . $helper->base_url('public/images/person_1.jpg') . '" alt="Bền Bò"> Bền Bò</span>&bullet;
                        <span class="mr-2">' . $blog['updated_time'] . '</span> &bullet;
                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                      </div>
                      <h2>' . $blog['title'] . '</h2>
                    </div>
                  </a>
                </div>';
                    }
                    ?>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <nav aria-label="Page navigation" class="text-center">
                            <!-- <ul class="pagination">
                                <li class="page-item  active"><a class="page-link" href="#">&lt;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="index.php?page=2">2</a></li>

                                <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                            </ul> -->
                            <ul class="pagination">


                                <?php
                                if ($current_page > 1) {
                                    $prev = $current_page - 1;
                                    echo '<li class="page-item "><a class="page-link" href="index.php?page=' . $prev . '">&lt;</a></li>';
                                }
                                for ($i = 1; $i <= $total_page; $i++) {

                                    $active = $current_page == $i ? 'active' : '';
                                    if ($active == 'active') {
                                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="#">' . $i . '</a></li>';
                                    } else {
                                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    if ($total_page >= 12) {
                                        if ($i == ($current_page + 5)) {
                                            echo '<li class="page-item "><a class="page-link" href="#">...</a></li>';
                                            echo '<li class="page-item "><a class="page-link" href="#">' . $total_page . '</a></li>';
                                            break;
                                        }
                                    }
                                }
                                if ($current_page < $total_page) {
                                    $next = $current_page + 1;
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $next . '">&gt;</a></li>';
                                }
                                ?>


                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END main-content -->
            <!-- START SIDEBAR -->
            <?php require_once(__DIR__ . '/sidebar.php'); ?>
            <!-- END sidebar -->
        </div>
    </div>
</section>
<!-- START FOOTER -->
<?php require_once(__DIR__ . '/footer.php'); ?>
<!-- END footer -->