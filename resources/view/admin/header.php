<?php
if (!$_SESSION['account']['isAdmin']) {
    header("Location: /admin/login");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?=$body['title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $helper->base_url('public/admin/images/favicon.ico') ?>">

    <!-- third party css -->
    <link href="<?= $helper->base_url('public/admin/css/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="<?= $helper->base_url('public/admin/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $helper->base_url('public/admin/css/app-modern.min.css') ?>" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= $helper->base_url('public/admin/css/app-modern-dark.min.css') ?>" rel="stylesheet" type="text/css" id="dark-style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="loading" data-layout="detached" data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <!-- Topbar Start -->
    <div class="navbar-custom topnav-navbar topnav-navbar-dark">
        <div class="container-fluid">

            <!-- LOGO -->
            <a href="/admin" class="topnav-logo">
                <span class="topnav-logo-lg">
                    <img src="<?= $helper->base_url('public/admin/images/logo-light.png') ?>" alt="" height="16">
                </span>
                <span class="topnav-logo-sm">
                    <img src="<?= $helper->base_url('public/admin/images/logo_sm.png') ?>" alt="" height="16">
                </span>
            </a>

            <ul class="list-unstyled topbar-right-menu float-right mb-0">

                <!-- <li class="dropdown notification-list d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="dripicons-search noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                        </form>
                    </div>
                </li> -->

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="account-user-avatar">
                            <img src="<?= $helper->base_url('public/admin/images/users/avatar-1.jpg') ?>" alt="user-image" class="rounded-circle">
                        </span>
                        <span>
                            <span class="account-user-name">Dominic Keller</span>
                            <span class="account-position">Founder</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle mr-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-edit mr-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-lifebuoy mr-1"></i>
                            <span>Support</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-lock-outline mr-1"></i>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout mr-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

            </ul>
            <a class="button-menu-mobile disable-btn">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <div class="app-search dropdown">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." id="top-search">
                        <span class="mdi mdi-magnify search-icon"></span>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-notes font-16 mr-1"></i>
                        <span>Analytics Report</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-life-ring font-16 mr-1"></i>
                        <span>How can I help you?</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-cog font-16 mr-1"></i>
                        <span>User profile settings</span>
                    </a>

                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                    </div>

                    <div class="notification-list">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="media">
                                <img class="d-flex mr-2 rounded-circle" src="<?= $helper->base_url('public/admin/images/users/avatar-2.jpg') ?>" alt="Generic placeholder image" height="32">
                                <div class="media-body">
                                    <h5 class="m-0 font-14">Erwin Brown</h5>
                                    <span class="font-12 mb-0">UI Designer</span>
                                </div>
                            </div>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="media">
                                <img class="d-flex mr-2 rounded-circle" src="<?= $helper->base_url('public/admin/images/users/avatar-5.jpg') ?>" alt="Generic placeholder image" height="32">
                                <div class="media-body">
                                    <h5 class="m-0 font-14">Jacob Deo</h5>
                                    <span class="font-12 mb-0">Developer</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <!-- Begin page -->
        <div class="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu left-side-menu-detached">

                <div class="leftbar-user">
                    <a href="javascript: void(0);">
                        <img src="<?= $helper->base_url('public/admin/images/users/avatar-1.jpg') ?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name"><?php echo $username ?? '' ?></span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="metismenu side-nav">

                    <li class="side-nav-title side-nav-item">Trang Chủ</li>

                    <li class="side-nav-item">
                        <a href="/admin" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge badge-info badge-pill float-right">4</span>
                            <span>Dashboards</span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">Bài Viết</li>

                    
                    <li class="side-nav-item">
                        <a href="/admin/post" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span>Danh Sách</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="/admin/create" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span>Thêm Bài Viết</span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">Chức Năng</li>

                    
                    <li class="side-nav-item">
                        <a href="/admin/author" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span>Tác giả</span>
                        </a>
                    </li>
                </ul>

                <!-- End Sidebar -->

                <div class="clearfix"></div>
                <!-- Sidebar -left -->

            </div>
            <!-- Right Sidebar -->
            <div class="right-bar">

                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-right">
                        <i class="dripicons-cross noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <div class="rightbar-content h-100" data-simplebar>

                    <div class="p-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                        </div>

                        <!-- Settings -->
                        <h5 class="mt-3">Color Scheme</h5>
                        <hr class="mt-1" />

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light" id="light-mode-check" checked />
                            <label class="custom-control-label" for="light-mode-check">Light Mode</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark" id="dark-mode-check" />
                            <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
                        </div>

                        <!-- Left Sidebar-->
                        <h5 class="mt-4">Left Sidebar</h5>
                        <hr class="mt-1" />

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check" checked />
                            <label class="custom-control-label" for="fixed-check">Scrollable</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="compact" value="condensed" id="condensed-check" />
                            <label class="custom-control-label" for="condensed-check">Condensed</label>
                        </div>

                        <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>

                        <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/" class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase
                            Now</a>
                    </div> <!-- end padding-->

                </div>
            </div>
            <div class="rightbar-overlay"></div>