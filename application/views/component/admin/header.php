<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Inzomnia &mdash; <?=$title?></title>



    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=base_url('assets/')?>modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>modules/fontawesome/css/all.min.css">


    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?=base_url('assets/')?>modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="<?=base_url('assets/')?>modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">



    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/')?>css/style.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>css/custom/style.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>css/components.css">

    <style>
    .overflow-horizontal {
        overflow-x: auto;
        /* Aktifkan scroll horizontal */
        padding-bottom: 1rem;
        /* Tambahkan padding untuk scroll bar */
    }

    .flex-nowrap {
        display: flex;
        /* Gunakan flexbox */
        gap: 1rem;
        /* Beri jarak antar elemen */
        white-space: nowrap;
        /* Mencegah elemen turun ke baris berikutnya */
    }
    </style>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?=base_url()?>assets/img/avatar/avatar-4.png"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?=$this->session->userdata('nama')?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="<?=base_url('auth/logout')?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>