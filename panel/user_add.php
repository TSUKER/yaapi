<?php

include '../config.php';
if (isset($_GET['company'])) {
    $companyID = (int)$_GET['company'];
} else {
    die('no companyid');
}
if (isset($_POST['nickname'])) {


    $arraayS = array();

    $arraayS['nickname'] = $_POST['nickname'];
    if ($_POST['about'] <> '') {
        $arraayS['about'] = $_POST['about'];
    }
    if ($_POST['birthday'] <> '') {
        $arraayS['birthday'] = $_POST['birthday'];
    }
    if ($_POST['department'] <> '') {
        $arraayS['department_id'] = (int)$_POST['department'];
    }
    if ($_POST['gender'] <> '') {
        $arraayS['gender'] = $_POST['gender'];
    }
    if ($_POST['position'] <> '') {
        $arraayS['position'] = $_POST['position'];
    }

    if ($allowFunc['add_admin'] == true) {
        if ($_POST['is_admin'] == 'true') {
            $arraayS['is_admin'] = true;
        } else {
            $arraayS['is_admin'] = false;
        }
    } else {
        $arraayS['is_admin'] = false;
    }

    if ($_POST['is_dismissed'] == 'true') {
        $arraayS['is_dismissed'] = true;
    }


    $arraayS['name'] = array();
    if ($_POST['fname'] <> '') {
        $arraayS['name']['first'] = $_POST['fname'];
    }
    if ($_POST['lname'] <> '') {
        $arraayS['name']['last'] = $_POST['lname'];
    }
    if ($_POST['mname'] <> '') {
        $arraayS['name']['middle'] = $_POST['mname'];
    }
    if ($_POST['password-input'] <> 'hunter2') {
        $arraayS['password'] = $_POST['password-input'];
    }


    //  var_dump(json_encode($arraayS));
    ////////////////////////////////////////////
    ///
    $URL = 'https://api.directory.yandex.net/v6/users/';
    $data_string = json_encode($arraayS);
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Org-ID: ' . $companyID,
            'Authorization: OAuth ' . $token)
    );

    $result = curl_exec($ch);
    // var_dump($result);
    $df = json_decode($result, true);

//var_dump($data_string);

    $info = curl_getinfo($ch);
    //  var_dump($info);
    //  var_dump($_POST);

    switch ($http_code = $info['http_code']) {
        case 201:
            $text = 'Пользователь создан.';
            break;
        case 403:
            $text = 'У пользователя или приложения нет прав на доступ к ресурсу, запрос отклонен.';
            break;
        case 404:
            $text = 'Запрашиваемый ресурс не найден.';
            break;
        case 409:
            $text = 'Запрос не может быть выполнен по причине конфликта имен.';
            break;
        case 422:
            $text = 'Ошибка валидации, запрос отклонен.';
            break;
        case 500:
            $text = 'Внутренняя ошибка сервиса. Попробуйте повторно отправить запрос через некоторое время.';
            break;
        case 503:
            $text = 'Сервис API временно недоступен.';
            break;
        default:
            $text = 'Unexpected HTTP code: ' . $http_code . "\n";
    }
    $rt = '';
    if (is_array($df)) {
        $rt .= ' |' . $df['message'];
    }
    $echoSTRING = $text . $rt;
    /// ///////////////////////////////////////

}
//nickname


$dFields = 'id,name';
$URL = 'https://api.directory.yandex.net/v6/departments/?per_page=997&fields=' . $dFields;
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
$depInfo = json_decode($result, true);
$departments = array();
foreach ($depInfo['result'] as $deps) {
    $departments[$deps['id']] = $deps['name'];
}
///
///
///

///
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
        <div class="page-content">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title mb-1">Новое</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Создание сотрудника</li>


                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="page-content-wrapper">
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Данные профиля</h4>
                                    <p class="card-title-desc">Поля при сохранении перезаписываются</p>
                                    <?php
                                    if (isset($echoSTRING)) {
                                        ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $echoSTRING; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <form method="post"
                                          action="user_add.php?company=<?php echo $companyID; ?>">

                                        <input type="hidden" name="is_dismissed" value="false">
                                        <input type="hidden" name="is_enabled" value="true">

                                        <div class="form-group row">
                                            <label for="example-search-input"
                                                   class="col-md-2 col-form-label">Фамилия</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"
                                                       placeholder="<фамилия сотрудника>" name="lname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input"
                                                   class="col-md-2 col-form-label">Имя</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"
                                                       placeholder="<имя сотрудника>" name="fname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input"
                                                   class="col-md-2 col-form-label">Отчество</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"
                                                       placeholder="<отчество сотрудника>" name="mname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">О
                                                сотруднике</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="about"
                                                       placeholder="<описание сотрудника>" id="example-text-input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input"
                                                   class="col-md-2 col-form-label">Должность</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="position"
                                                       placeholder="<должность>"
                                                       id="example-text-input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Логин
                                                сотрудника</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="nickname"
                                                       id="example-text-input" placeholder="<логин>"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-datetime-local-input" class="col-md-2 col-form-label">Дата
                                                рождения</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="birthday"
                                                       value="1999-11-11"
                                                       id="example-datetime-local-input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-number-input" class="col-md-2 col-form-label">
                                                Отдел к которому относится сотрудник.</label>
                                            <div class="col-md-10">
                                                <select class="custom-select" name="department">
                                                    <?php
                                                    foreach ($departments as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">Пол</label>
                                            <div class="col-md-10">
                                                <select name="gender" class="form-control">

                                                    <option value="male">мужской</option>
                                                    <option value="female">женский</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">Администратор</label>

                                            <div class="col-md-10">
                                                <select name="is_admin" class="form-control">
                                                    <option value="true">Да</option>
                                                    <option selected value="false">Нет</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-password-input"
                                                   class="col-md-2 col-form-label">Пароль</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" required="required"
                                                       placeholder="<пароль сотрудника>"
                                                       name="password-input">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Применить
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>


            <!-- end page-content-wrapper -->
        </div>
        <!-- End Page-content -->

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
<script src="assets/js/app.js"></script>
</body>