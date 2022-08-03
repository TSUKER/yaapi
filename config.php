<?php
$APP_ID = 'example id'; // ID app yandex
$APP_PWD =  'example password'; // Password app yandex

$token = 'example OAuth token'; // Token YANDEX API 

$XOrgID = 1;

$nameServices = array(
    'calendar' => 'Календарь',
    'disk' => 'Яндекс.Диск',
    'mail' => 'Яндекс.Почта',
    'portal' => 'Администрирование',
    'search' => 'Поиск по организации',
    'staff' => 'Люди и команды',
    'tracker' => 'Яндекс.Трекер',
    'wiki' => 'Яндекс.Вики',
    'yamb' => 'Ямб',
    'botsman' => 'botsman'
);
$allowFunc = array(
    'add_admin' => true,
    'edit_admin' => true,
    'edit_pwd' => true,

    'block' => true,
    'unblock' => true,
    'dismissed' => true
);

function uniqidReal($lenght = 13)
{
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
function clearGETdata($str)
{
    $str = str_replace('"', "", $str);
    $str = str_replace("'", "", $str);
    $str = preg_replace("/\/\/.*?\n/", "\n", $str);
    $str = stripslashes($str);
    return $str;
}


require_once 'vendor/autoload.php';