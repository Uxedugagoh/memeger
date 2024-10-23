<?php

session_start();
    require_once '../../config/connect.php';

    if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
    }


$user_id = $_SESSION['user']['user_id'];

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);

$finance_info = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_id'");
$fnnc_info = mysqli_fetch_assoc($finance_info);
$balance = $fnnc_info['user_money'];

$building = ($_POST['building']);
$building_value = intval($_POST['building_value']);

// Если меняешь стоимости, поменяй эти стоимости и в описаниях на странице buildings.php

if ($building == 'team_base') {
    if (($building_value == 2) && ($bldngs_info['team_base'] == 1)) {
        $building_cost = 5000;
    } elseif (($building_value == 3) && ($bldngs_info['team_base'] == 2)) {
        $building_cost = 10000;
    } elseif (($building_value == 4) && ($bldngs_info['team_base'] == 3)) {
        $building_cost = 20000;
    } elseif (($building_value == 5) && ($bldngs_info['team_base'] == 4)) {
        $building_cost = 40000;
    } else $_SESSION['building_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/buildings.php');
} elseif ($building == 'office') {
    if (($building_value == 1) && ($bldngs_info['office'] == 0) && ($bldngs_info['team_base'] >= 2)) {
        $building_cost = 2000;
    } elseif (($building_value == 2) && ($bldngs_info['office'] == 1) && ($bldngs_info['team_base'] >= 3)) {
        $building_cost = 5000;
    } elseif (($building_value == 3) && ($bldngs_info['office'] == 2) && ($bldngs_info['team_base'] >= 4)) {
        $building_cost = 10000;
    } else $_SESSION['building_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/buildings.php');
} elseif ($building == 'sport_school') {
    if (($building_value == 1) && ($bldngs_info['sport_school'] == 0) && ($bldngs_info['team_base'] >= 3)) {
        $building_cost = 20000;
    } elseif (($building_value == 2) && ($bldngs_info['sport_school'] == 1) && ($bldngs_info['team_base'] >= 4)) {
        $building_cost = 30000;
    } elseif (($building_value == 3) && ($bldngs_info['sport_school'] == 2) && ($bldngs_info['team_base'] >= 5)) {
        $building_cost = 50000;
    } else $_SESSION['building_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/buildings.php');
} elseif ($building == 'medical_center') {
    if (($building_value == 1) && ($bldngs_info['medical_center'] == 0) && ($bldngs_info['team_base'] >= 3)) {
        $building_cost = 20000;
    } elseif (($building_value == 2) && ($bldngs_info['medical_center'] == 1) && ($bldngs_info['team_base'] >= 4)) {
        $building_cost = 30000;
    } elseif (($building_value == 3) && ($bldngs_info['medical_center'] == 2) && ($bldngs_info['team_base'] >= 5)) {
        $building_cost = 50000;
    } else $_SESSION['building_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/buildings.php');
} else header('Location: ../../organization/buildings.php');







if (!$_SESSION['building_accepted_error_1']) {
    if ($building_cost > $balance) {
    $_SESSION['building_accepted_error_2'] = 'Недостаточно средств!';
    header('Location: ../../organization/buildings.php');
    }
}

if (!$_SESSION['building_accepted_error_1'] && !$_SESSION['building_accepted_error_2']) {
    $user_money = $balance - $building_cost;
    mysqli_query($connect, "UPDATE `buildings` SET `$building` = '$building_value' WHERE `user_id` = $user_id");
    mysqli_query($connect, "UPDATE `teams` SET `user_money` = '$user_money' WHERE `user_id` = $user_id");

    $_SESSION['building_completed'] = 'Строительство завершено!';
        header('Location: ../../organization/buildings.php');
}



?>