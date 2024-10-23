<?php

session_start();
    require_once '../../config/connect.php';

    if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
    }

    $training_keys_array = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
        21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
        31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
        41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
        51, 52, 53, 54, 55, 56, 57, 58, 59, 60,
        61, 62, 63, 64, 65, 66, 67, 68, 69, 70,
        71, 72, 73, 74, 75, 76, 77, 78, 79, 80,
        81, 82, 83, 84, 85, 86, 87, 88, 89, 90,
        91, 92, 93, 94, 95, 96, 97, 98, 99, 100
    ];
    
    $training_values_array = [
        15, 20, 25, 30, 35, 40, 45, 50, 60, 70,
        80, 90, 100, 110, 120, 130, 140, 150, 160, 170, // +10
        190, 210, 230, 250, 270, 290, 310, 330, 350, 370, // +20
        400, 430, 460, 490, 520, 550, 580, 610, 640, 670, // +30
        710, 750, 790, 830, 870, 910, 950, 990, 1030, 1070, // +40
        1120, 1170, 1220, 1270, 1320, 1370, 1420, 1470, 1520, 1570, // +50
        1630, 1690, 1750, 1810, 1870, 1930, 1990, 2050, 2110, 2170, // +60
        2240, 2310, 2380, 2450, 2520, 2590, 2660, 2730, 2800, 2870, // +70
        2950, 3030, 3110, 3190, 3270, 3350, 3430, 3510, 3590, 3670, // +80
        3760, 3850, 3940, 4030, 4120, 4210, 4300, 4390, 4480, 4570
    ]; // +90
    
    $training_array_straight = array_combine($training_keys_array, $training_values_array);


$user_id = $_SESSION['user']['user_id'];

$player_id = (intval($_POST['player_id']));
$player_ability = ($_POST['player_ability']);
$ability_level = (intval($_POST['ability_level']));
$experience_spent = (floatval($_POST['experience_spent']));
$remaining_experience = (floatval($_POST['remaining_experience']));

$data_check = mysqli_query($connect, "SELECT $player_ability, player_experience FROM `players` WHERE `user_id` = $user_id AND `player_id` = $player_id /*ORDER BY warehouse_id DESC*/");
$dta_check = mysqli_fetch_assoc($data_check);

$data_check_1 = array_shift($dta_check);

$experience_spent_check = $training_array_straight[$data_check_1 + 1];


if (($data_check_1 == ($ability_level-1)) && ($experience_spent == $experience_spent_check) && ($remaining_experience == ($dta_check['player_experience'] - $experience_spent_check))) {

    mysqli_query($connect, "UPDATE `players` SET `player_experience` = '$remaining_experience', `$player_ability` = '$ability_level' WHERE `user_id` = $user_id AND `player_id` = $player_id");

$_SESSION['training_accepted'] = 'Тренеровка произошла!';
    header('Location: ../../players/training.php');
} else {
    $_SESSION['training_error'] = 'че сука самый умный бля ты кого наебать пытаешься';
    header('Location: ../../players/training.php');
}



?>