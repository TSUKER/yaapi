<?php
include '../config.php';


$URL = 'https://api.directory.yandex.net/v6/organizations/?fields=revision,id,label,admin_uid,email,services,disk_limit,subscription_plan,country,language,name,fax,disk_usage,phone_number,domains';// users/?per_page=990';
$data_string = json_encode(array());
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        /* 'X-Org-ID: ',*/
        'Authorization: OAuth ' . $token)
);
$result = curl_exec($ch);

file_put_contents('tmp.log.txt', date(DATE_RFC822) . ' JSON: ' .
    $result . PHP_EOL);

$cInfo = json_decode($result, true);


?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>Dashboard | ACAPI </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Yandex Connect API" name="description"/>
    <meta content="A Shumko" name="author"/>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css"/>
</head>
<body data-topbar="colored" data-layout="horizontal" data-layout-size="boxed">

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="container-fluid">


                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm-dark.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="20">
                                </span>
                    </a>

                    <a href="index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm-light.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </span>
                    </a>
                </div>

                <button type="button"
                        class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light"
                        data-toggle="collapse" data-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <div class="topnav">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">
                                        Главная
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components"
                                       role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Информация
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-components">
                                        <div class="dropdown">
                                            <a class="dropdown-item" href="users.php"
                                            >
                                                <div class="d-inline-block icons-sm mr-2"><i class="ti-user"></i>
                                                </div>
                                                Пользователи

                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>


    </header>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <?php
        foreach ($cInfo['result'] as $company) {

            //getsall domains
            $dFields = 'mx,delegated,tech,pop_enabled,master,postmaster_uid,owned,country,name,imap_enabled';
            $URL = 'https://api.directory.yandex.net/v6/domains/?per_page=997&fields=' . $dFields;
            $data_string = json_encode(array());
            $ch = curl_init($URL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'X-Org-ID: ' . $company['id'],
                    'Authorization: OAuth ' . $token)
            );
            $result = curl_exec($ch);
            $dInfo = json_decode($result, true);
//var_dump($dInfo);
            ?>
            <div class="page-content">

                <!-- Page-Title -->
                <div class="page-title-box">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="page-title mb-1">Основное</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Основные данные о компании</li>
                                </ol>

                            </div>
                            <div class="col-md-4">
                                <div class="float-right d-none d-md-block">
                                    <div class="dropdown">
                                        <a class="btn btn-light btn-rounded dropdown-toggle"
                                           href="users.php?company=<?php echo $company['id']; ?>">
                                            <i class="dripicons-user"></i> Сотрудники
                                        </a>
                                    </div>

                                    <div class="dropdown">
                                        <a class="btn btn-light btn-rounded dropdown-toggle"
                                           href="user_add.php?company=<?php echo $company['id']; ?>">
                                            <i class="dripicons-user"></i> Добавить сотрудника
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end page title end breadcrumb -->

                <div class="page-content-wrapper">
                    <div class="container-fluid">

                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header bg-transparent p-3">
                                        <h5 class="header-title mb-0">Организация</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Название организации</p>
                                                    <h5 class="mb-0"><?php echo $company['name']; ?></h5>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="media my-2">

                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Номер ревизии организации</p>
                                                    <h5 class="mb-0"><?php echo $company['revision']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Идентификатор организации</p>
                                                    <h5 class="mb-0"><?php echo $company['id']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Обозначение организации</p>
                                                    <h5 class="mb-0"><?php echo $company['label']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Предел доступного пространства</p>
                                                    <h5 class="mb-0"><?php echo $company['disk_limit']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Объем используемого пространства</p>
                                                    <h5 class="mb-0"><?php echo $company['disk_usage']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Обозначение страны организации</p>
                                                    <h5 class="mb-0"><?php echo $company['country']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Предел доступного пространства</p>
                                                    <h5 class="mb-0"><?php echo $company['email']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Основная электронная почта</p>
                                                    <h5 class="mb-0"><?php echo $company['email']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Номер факса</p>
                                                    <h5 class="mb-0"><?php echo $company['fax']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Номер телефона</p>
                                                    <h5 class="mb-0"><?php echo $company['phone_number']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Тип подписки на Яндекс.Коннект</p>
                                                    <h5 class="mb-0"><?php echo $company['subscription_plan']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Язык интерфейса для сотрудников
                                                        организации</p>
                                                    <h5 class="mb-0"><?php echo $company['language']; ?></h5>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header bg-transparent p-3">
                                        <h5 class="header-title mb-0">Сервисы</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php


                                        foreach ($company['services'] as $service) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="media my-2">
                                                    <div class="media-body">
                                                        <p class="text-muted mb-2"><?php echo $nameServices[$service['slug']]; ?>
                                                        </p>

                                                        <h5 class="mb-0">
                                                            Trial:<?php echo $service['trial_expires']; ?> <?php echo $service['trial_expired']; ?></h5>
                                                        <h5 class="mb-0">До:<?php echo $service['expires_at']; ?></h5>
                                                        <h5 class="mb-0">User
                                                            limit:<?php echo $service['user_limit']; ?></h5>
                                                    </div>
                                                    <div class="icons-lg ml-2 align-self-center">
                                                        <?php
                                                        if ($service['ready'] == true) {
                                                            echo '<span class="badge badge-pill badge-success">Готов к работе</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill badge-danger">Не готов к работе</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header bg-transparent p-3">
                                        <h5 class="header-title mb-0">Домены</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Имя основного домена</p>
                                                    <h5 class="mb-0"><?php echo $company['domains']['display']; ?></h5>
                                                </div>
                                                <div class="icons-lg ml-2 align-self-center">
                                                    <i class=" uim uim-cube"></i>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media my-2">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2">Имя технического домена</p>
                                                    <h5 class="mb-0"><?php echo $company['domains']['master']; ?></h5>
                                                </div>
                                                <div class="icons-lg ml-2 align-self-center">
                                                    <i class="uim uim-cube"></i>
                                                </div>
                                            </div>
                                        </li>


                                        <?php

                                        foreach ($dInfo as $Dvalue) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="media my-2">
                                                    <div class="media-body">
                                                        <p class="text-muted mb-2">Домен <?php echo $Dvalue['name']; ?>
                                                        </p>
                                                        <h5 class="mb-0"><?php

                                                            if ($Dvalue['master'] == true) {
                                                                echo '<span class="badge badge-success">основной домен</span>';
                                                            } else {
                                                                echo '<span class="badge badge-light">домен-алиас</span>';
                                                            }

                                                            if ($Dvalue['tech'] == true) {
                                                                echo '<span class="badge badge-success">технический домен</span>';
                                                            } else {
                                                                echo '<span class="badge badge-light">обычный домен</span>';
                                                            }


                                                            if ($Dvalue['delegated'] == true) {
                                                                echo '<span class="badge badge-success">делегирован</span>';
                                                            } else {
                                                                echo '<span class="badge badge-danger">не делегирован</span>';
                                                            }
                                                            if ($Dvalue['owned'] == true) {
                                                                echo '<span class="badge badge-success">подтвержден</span>';
                                                                if ($Dvalue['mx'] == true) {
                                                                    echo '<span class="badge badge-success">MX</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">MX</span>';
                                                                }

                                                                if ($Dvalue['pop_enabled'] == true) {
                                                                    echo '<span class="badge badge-success">POP</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">POP</span>';
                                                                }
                                                                if ($Dvalue['imap_enabled'] == true) {
                                                                    echo '<span class="badge badge-success">IMAP</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">IMAP</span>';
                                                                }
                                                            }

                                                            ?></h5>
                                                    </div>
                                                    <div class="icons-lg ml-2 align-self-center">
                                                        <i class="uim uim-link-h"></i>
                                                        <?php
                                                        echo '<span class="badge badge-success"><img src="https://hatscripts.github.io/circle-flags/flags/' . $Dvalue['country'] . '.svg" width="48"></span>';
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container-fluid -->
                </div>


                <!-- end page-content-wrapper -->
            </div>
            <!-- End Page-content -->

            <?php
        }
        ?>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        2022 © a.shumko
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Crafted with <i class="mdi mdi-heart text-danger"></i> by a.shumko
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
<script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>