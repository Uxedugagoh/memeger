<?php

session_start();
    require_once '../../config/connect.php';

    if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
    }


$user_id = $_SESSION['user']['user_id'];

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);

$staff_info = mysqli_query($connect, "SELECT * FROM `staff` WHERE `user_id` = '$user_id'");
$stff_info = mysqli_fetch_assoc($staff_info);

$finance_info = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_id'");
$fnnc_info = mysqli_fetch_assoc($finance_info);
$balance = $fnnc_info['user_money'];

$staff = ($_POST['staff']);
$staff_value = ($_POST['staff_value']);

// Если меняешь стоимости, поменяй эти стоимости и в описаниях на странице staff.php

if ($staff == 'coach') {
    if (($staff_value == 1) && ($stff_info['coach'] == 0) && ($bldngs_info['team_base'] >= 2)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['coach'] == 1) && ($bldngs_info['team_base'] >= 3)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['coach'] == 2) && ($bldngs_info['team_base'] >= 4)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} elseif ($staff == 'press_secretary') {
    if (($staff_value == 1) && ($stff_info['press_secretary'] == 0) && ($bldngs_info['team_base'] >= 3)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['press_secretary'] == 1) && ($bldngs_info['team_base'] >= 4)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['press_secretary'] == 2) && ($bldngs_info['team_base'] >= 5)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} elseif ($staff == 'scout') {
    if (($staff_value == 1) && ($stff_info['scout'] == 0) && ($bldngs_info['office'] >= 1)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['scout'] == 1) && ($bldngs_info['office'] >= 2)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['scout'] == 2) && ($bldngs_info['office'] >= 3)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} elseif ($staff == 'youth_coach') {
    if (($staff_value == 1) && ($stff_info['youth_coach'] == 0) && ($bldngs_info['sport_school'] >= 1)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['youth_coach'] == 1) && ($bldngs_info['sport_school'] >= 2)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['youth_coach'] == 2) && ($bldngs_info['sport_school'] >= 3)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} elseif ($staff == 'psychologist') {
    if (($staff_value == 1) && ($stff_info['psychologist'] == 0) && ($bldngs_info['medical_center'] >= 1)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['psychologist'] == 1) && ($bldngs_info['medical_center'] >= 2)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['psychologist'] == 2) && ($bldngs_info['medical_center'] >= 3)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} elseif ($staff == 'massagist') {
    if (($staff_value == 1) && ($stff_info['massagist'] == 0) && ($bldngs_info['medical_center'] >= 1)) {
        $staff_cost = 2000;
    } elseif (($staff_value == 2) && ($stff_info['massagist'] == 1) && ($bldngs_info['medical_center'] >= 2)) {
        $staff_cost = 8000;
    } elseif (($staff_value == 3) && ($stff_info['massagist'] == 2) && ($bldngs_info['medical_center'] >= 3)) {
        $staff_cost = 15000;
    } else $_SESSION['staff_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/staff.php');
} else header('Location: ../../organization/staff.php');






if (!$_SESSION['staff_accepted_error_1']) {
    if ($staff_cost > $balance) {
    $_SESSION['staff_accepted_error_2'] = 'Недостаточно средств!';
    header('Location: ../../organization/staff.php');
    }
}

if (!$_SESSION['staff_accepted_error_1'] && !$_SESSION['staff_accepted_error_2']) {
    $user_money = $balance - $staff_cost;
    mysqli_query($connect, "UPDATE `staff` SET `$staff` = '$staff_value' WHERE `user_id` = $user_id");
    mysqli_query($connect, "UPDATE `teams` SET `user_money` = '$user_money' WHERE `user_id` = $user_id");

    $_SESSION['staff_completed'] = 'Найм сотрудника выполнен!';
        header('Location: ../../organization/staff.php');
}



?>