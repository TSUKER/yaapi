<?php

include '../config.php';

if (isset($_GET['company'])) {
    $companyID = (int)$_GET['company'];
}

$uFields = 'is_robot,is_enabled,external_id,position,departments,org_id,gender,created,name,about,nickname,groups,is_admin,birthday,department_id,email,department.name,contacts,aliases,id,is_dismissed';
$URL = 'https://api.directory.yandex.net/v6/users/?per_page=997&fields=' . $uFields;
$data_string = json_encode(array());
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        'X-Org-ID: ' . $companyID,
        'Authorization: OAuth ' . $token)
);
$result = curl_exec($ch);
// file_put_contents('tmp.log.txt', date(DATE_RFC822) . ' JSON: ' . $result . PHP_EOL);

$uInfo = json_decode($result, true);
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
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>

</head>
<body data-topbar="colored" data-layout="horizontal" data-layout-size="boxed">
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
                                        <a class="dropdown-item" href="users.php">
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
    //  foreach ($cInfo['result'] as $company) {
    ?>
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Данные</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">пользователи</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">

                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title">Список сотрудников</h4>
                                <p class="card-title-desc">Список действующих и уволенных
                                </p>

                                <?php
                                if (isset($uInfo['code'])) {
                                    ?>
                                    <p class="card-title-desc">Ошибка: <?php
                                        echo $uInfo['message'];
                                        ?> , Сейчас будет сделана попытка получить все доступные компании и сотрудников
                                        в них.
                                    </p>
                                    <?php

                                    $URL = 'https://api.directory.yandex.net/v6/organizations/?fields=id,label,name';// users/?per_page=990';
                                    $data_string = json_encode(array());
                                    $ch = curl_init($URL);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json',
                                            'Accept: application/json',
                                            'Authorization: OAuth ' . $token)
                                    );
                                    $result = curl_exec($ch);
                                    $cInfo = json_decode($result, true);


                                }
                                ?>

                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>ID</th>

                                        <th>Организация</th>

                                        <th>Должность</th>
                                        <th>Отдел</th>

                                        <th>Имя (Отчество)</th>
                                        <th>Фамилия</th>
                                        <th>Email</th>

                                        <th>Логин сотрудника</th>

                                        <th>Дата рождения</th>
                                        <th>Псевдонимы</th>
                                        <th>Пол</th>
                                        <th>О сотруднике</th>

                                        <th>Статус сотрудника</th>
                                        <th>Ex ID</th>
                                        <th>Админ</th>
                                        <th>Робот</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <?php

                                    if (isset($uInfo['code'])) {
                                        foreach ($cInfo['result'] as $company) {
                                            $companyID = $company['id'];
                                            $URL = 'https://api.directory.yandex.net/v6/users/?per_page=997&fields=' . $uFields;
                                            $ch = curl_init($URL);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: application/json',
                                                    'Accept: application/json',
                                                    'X-Org-ID: ' . $companyID,
                                                    'Authorization: OAuth ' . $token)
                                            );
                                            $result = curl_exec($ch);
                                            $uInfo = json_decode($result, true);

                                            foreach ($uInfo['result'] as $user) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $user['id']; ?></td>

                                                    <td><?php echo $user['org_id']; echo '(' . $company['name'] . ')'; ?></td>

                                                    <td><?php echo $user['position']; ?></td>
                                                    <td><?php echo $user['department']['name']; ?></td>

                                                    <td><?php echo $user['name']['first'];
                                                        if (isset($user['name']['middle'])) {
                                                            echo $user['name']['middle'];
                                                        } ?></td>
                                                    <td><?php echo $user['name']['last']; ?></td>
                                                    <td><?php echo $user['email']; ?></td>

                                                    <td><?php echo $user['nickname']; ?></td>

                                                    <td><?php echo $user['birthday']; ?></td>
                                                    <td><?php echo implode(", ", $user['aliases']); ?></td>
                                                    <td><?php echo $user['gender']; ?></td>
                                                    <td><?php echo $user['about']; ?></td>

                                                    <td><?php if ($user['is_dismissed'] == true) {
                                                            echo 'уволенный';
                                                        } else {
                                                            echo 'действующий';
                                                        } ?>

                                                        <?php if ($user['is_enabled'] == true) {
                                                            echo 'активен';
                                                        } else {
                                                            echo 'заблокирован';
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $user['external_id']; ?></td>
                                                    <td><?php echo $user['is_admin']; ?></td>
                                                    <td><?php echo $user['is_robot']; ?></td>


                                                    <td>
                                                        <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                            <i class="dripicons-user"></i> Редактировать
                                                        </a>
                                                        <?php if ($user['is_dismissed'] == false) {
                                                            ?>
                                                            <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=des&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                                <i class="mdi mdi-delete"></i> Уволить
                                                            </a>
                                                            <?php
                                                        } ?>
                                                        <?php if ($user['is_enabled'] == false) {
                                                            ?>
                                                            <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=unblock&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                                <i class="mdi mdi-cached"></i> Разблокировать
                                                            </a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=block&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                                <i class="mdi mdi-block-helper"></i> Заблокировать
                                                            </a>
                                                            <?php
                                                        }?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }

                                        }
                                    } else {
                                        foreach ($uInfo['result'] as $user) {
                                            ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>

                                                <td><?php echo $user['org_id']; ?></td>

                                                <td><?php echo $user['position']; ?></td>
                                                <td><?php echo $user['department']['name']; ?></td>

                                                <td><?php echo $user['name']['first'];
                                                    if (isset($user['name']['middle'])) {
                                                        echo $user['name']['middle'];
                                                    } ?></td>
                                                <td><?php echo $user['name']['last']; ?></td>
                                                <td><?php echo $user['email']; ?></td>

                                                <td><?php echo $user['nickname']; ?></td>

                                                <td><?php echo $user['birthday']; ?></td>
                                                <td><?php echo implode(", ", $user['aliases']); ?></td>
                                                <td><?php echo $user['gender']; ?></td>
                                                <td><?php echo $user['about']; ?></td>

                                                <td><?php if ($user['is_dismissed'] == true) {
                                                        echo 'уволенный';
                                                    } else {
                                                        echo 'действующий';
                                                    } ?>
                                                    <?php if ($user['is_enabled'] == true) {
                                                        echo 'активен';
                                                    } else {
                                                        echo 'заблокирован';
                                                    } ?>
                                                </td>
                                                <td><?php echo $user['external_id']; ?></td>
                                                <td><?php echo $user['is_admin']; ?></td>
                                                <td><?php echo $user['is_robot']; ?></td>
                                                <td>
                                                    <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                        <i class="dripicons-user"></i> Редактировать
                                                    </a>
                                                    <?php if ($user['is_dismissed'] == false) {
                                                        ?>
                                                        <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=des&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                            <i class="mdi mdi-delete"></i> Уволить
                                                        </a>
                                                        <?php
                                                    } ?>
                                                    <?php if ($user['is_enabled'] == false) {
                                                        ?>
                                                        <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=unblock&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                            <i class="mdi mdi-cached"></i> Разблокировать
                                                        </a>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a class="btn btn-light btn-rounded dropdown-toggle" href="user.php?act=block&user=<?php echo $user['id']; ?>&company=<?php echo $companyID; ?>">
                                                            <i class="mdi mdi-block-helper"></i> Заблокировать
                                                        </a>
                                                        <?php
                                                    }?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }


                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

    <?php
    //  }
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

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>

<script src="assets/js/app.js"></script>
</body>
</html>



