<?php

session_start();
    require_once '../../config/connect.php';

    if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
    }

$arena_keys = array();

for ($i = 0; $i < 10000; $i++) {
    $arena_keys[$i] = $i + 1;
}

$arena_levels = array();

for ($i = 0; $i < 10000; $i++) {
    if ($i == 0) {
        $arena_levels[$i] = 20;
        continue;
    }
    $arena_coef = ((20 * (1 + ($i * 0.01))) + $arena_levels[$i - 1]);
    $arena_levels[$i] = $arena_coef;
}

$finalArray = array_combine($arena_keys, $arena_levels);


$user_id = $_SESSION['user']['user_id'];

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);

$finance_info = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_id'");
$fnnc_info = mysqli_fetch_assoc($finance_info);
$balance = $fnnc_info['user_money'];

$capacity = intval($_POST['capacity']);

$money_spent_check = $finalArray[$capacity];


if ($bldngs_info['team_base'] == 1) {
    if (($bldngs_info['arena'] > $capacity) || ($capacity < 51) || ($capacity > 1000)) {
    $_SESSION['arena_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/arena.php');
    }
} elseif ($bldngs_info['team_base'] == 2) {
    if (($bldngs_info['arena'] > $capacity) || ($capacity < 51) || ($capacity > 2000)) {
    $_SESSION['arena_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/arena.php');
    }
} elseif ($bldngs_info['team_base'] == 3) {
    if (($bldngs_info['arena'] > $capacity) || ($capacity < 51) || ($capacity > 3500)) {
    $_SESSION['arena_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/arena.php');
    }
} elseif ($bldngs_info['team_base'] == 4) {
    if (($bldngs_info['arena'] > $capacity) || ($capacity < 51) || ($capacity > 5000)) {
    $_SESSION['arena_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/arena.php');
    }
} elseif ($bldngs_info['team_base'] == 5) {
    if (($bldngs_info['arena'] > $capacity) || ($capacity < 51) || ($capacity > 10000)) {
    $_SESSION['arena_accepted_error_1'] = 'Ошибка';
    header('Location: ../../organization/arena.php');
    }
}







if (!$_SESSION['arena_accepted_error_1']) {
    if ($money_spent_check > $balance) {
    $_SESSION['arena_accepted_error_2'] = 'Недостаточно средств!';
    header('Location: ../../organization/arena.php');
    }
}

if (!$_SESSION['arena_accepted_error_1'] && !$_SESSION['arena_accepted_error_2']) {
    $user_money = $balance - $money_spent_check;
    mysqli_query($connect, "UPDATE `buildings` SET `arena` = '$capacity' WHERE `user_id` = $user_id");
    mysqli_query($connect, "UPDATE `teams` SET `user_money` = '$user_money' WHERE `user_id` = $user_id");

    $_SESSION['arena_completed'] = 'Строительство завершено!';
        header('Location: ../../organization/arena.php');
}



?>