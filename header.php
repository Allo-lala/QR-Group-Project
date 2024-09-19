<?php
session_start(); // Ensure session is started

include './root/process.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SESSION['id'])) {
  header("Location: login");
  exit(); // Always exit after redirect
} else {
  // Ensure session variables are set with fallback values
  $interface = isset($_SESSION['role']) ? $_SESSION['role'] : 'Unknown Role';
  $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Guest';
  $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : 'N/A';
  $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 'N/A';
  $date_registered = isset($_SESSION['date_registered']) ? $_SESSION['date_registered'] : 'N/A';

  // If you use the $user variable somewhere else, initialize it properly
  // $user = [
  //   'role' => $interface,
  //   'fullname' => $fullname,
  //   'phone' => $phone,
  //   'userid' => $userid,
  //   'date_registered' => $date_registered
  // ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LSkS | Dashboard</title>
  <link rel="shortcut icon" href="./logo.png">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  
  <!-- Preloader CSS -->
  <style>
    .preloader {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease-out;
    }
    .preloader.hidden {
      opacity: 0;
      visibility: hidden;
    }
    .spinner-border {
      width: 3rem;
      height: 3rem;
      border-width: 0.4em;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="preloader">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <!-- <a href="index3.html" class="brand-link">
        <div class="brand-image img-circle elevation-3" style="opacity: .8">LSK</div>
        <span class="brand-text font-weight-light">LSK</span>
      </a> -->

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="./root/images/logoz.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <!-- <div class="info">
            <a href="#" class="d-block">Welcome Admin</a>
          </div> -->
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php if($_SESSION['user_role'] === 'super admin') { ?>
              <li class="nav-item menu-open">
                <a href="<?= SITE_URL ?>" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="users" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="products" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Products
                  </p>
                </a>
              </li>
            <?php } ?>
            <li class="nav-item">
              <a href="qr-generator" class="nav-link">
                <i class="nav-icon fas fa-qrcode"></i>
                <p>
                  <?php if($_SESSION['user_role'] === 'super admin') { ?>Generate<?php } ?> QR
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="logout" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    
  
  <!-- Preloader Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      setTimeout(function() {
        document.querySelector('.preloader').classList.add('hidden');
      }, 4000); // 1 second delay
    });
  </script>

