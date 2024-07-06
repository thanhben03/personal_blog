<?php
$body = [
    'title' => 'Admin Panel - Blog IT'
];
require_once(__DIR__ . '/header.php');
$sql = "SELECT  (
    SELECT COUNT(*)
    FROM   b_post
    ) AS total_post,
    (
    SELECT COUNT(*)
    FROM   b_comment
    ) AS total_comment,
    (
    SELECT COUNT(*)
    FROM   b_categories
    ) AS total_cate,
    (
    SELECT COUNT(*)
    FROM   b_tags
    ) AS total_tag
    FROM    dual";
$posts_stat = $db->getOneRowWithSQL($sql);
// echo $sql;
// print_r($posts_stat);
// die();


?>
<!-- end Topbar -->

<!-- Left Sidebar End -->

<div class="content-page">
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-light" id="dash-daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary border-primary text-white">
                                            <i class="mdi mdi-calendar-range font-13"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-primary ml-2">
                                <i class="mdi mdi-autorenew"></i>
                            </a>
                            <a href="javascript: void(0);" class="btn btn-primary ml-1">
                                <i class="mdi mdi-filter-variant"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Thống kê hệ thống</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-success text-xl">
                                <i class="ion ion-ios-refresh-empty"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                     </span>
                                <span class="text-muted">Account</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-warning text-xl">
                                <i class="ion ion-ios-cart-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    0 </span>
                                <span class="text-muted">Số lượng truy cập</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <p class="text-danger text-xl">
                                <i class="ion ion-ios-people-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    4 </span>
                                <span class="text-muted">THÀNH VIÊN MỚI</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Thống kê bài viết</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-success text-xl">
                                <i class="ion ion-ios-refresh-empty"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                <?=$posts_stat['total_post']?> </span>
                                <span class="text-muted">Số bài viết</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-warning text-xl">
                                <i class="ion ion-ios-cart-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                <?=$posts_stat['total_comment']?> </span>
                                <span class="text-muted">Comments</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <p class="text-danger text-xl">
                                <i class="ion ion-ios-people-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                <?=$posts_stat['total_cate']?> </span>
                                <span class="text-muted">Mục lục</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <p class="text-danger text-xl">
                                <i class="ion ion-ios-people-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                <?=$posts_stat['total_tag']?> </span>
                                <span class="text-muted">Tags</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- End Content -->
</div>
    <!-- Footer Start -->
    <?php
    require_once(__DIR__ . '/footer.php');
    ?>