<?php
session_start();
require_once '../config/connect.php';
require_once '../vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

/* Проверить на существование игры*/
$game_id = (intval($_GET['game_id']));

$game_info = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
$gm_info = mysqli_fetch_assoc($game_info);
$user_1 = $gm_info['user_1'];
$user_2 = $gm_info['user_2'];
$player_1 = $gm_info['player_1'];
$player_2 = $gm_info['player_2'];
$player_3 = $gm_info['player_3'];
$player_4 = $gm_info['player_4'];
$player_5 = $gm_info['player_5'];
$player_6 = $gm_info['player_6'];
$player_7 = $gm_info['player_7'];
$player_8 = $gm_info['player_8'];
$player_9 = $gm_info['player_9'];
$player_10 = $gm_info['player_10'];

$team_1_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1'");
$tm_1_name = mysqli_fetch_assoc($team_1_name);

$team_2_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2'");
$tm_2_name = mysqli_fetch_assoc($team_2_name);

$player_1_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_1'");
$plr_1_name = mysqli_fetch_assoc($player_1_name);
$player_2_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_2'");
$plr_2_name = mysqli_fetch_assoc($player_2_name);
$player_3_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_3'");
$plr_3_name = mysqli_fetch_assoc($player_3_name);
$player_4_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_4'");
$plr_4_name = mysqli_fetch_assoc($player_4_name);
$player_5_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_5'");
$plr_5_name = mysqli_fetch_assoc($player_5_name);
$player_6_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_6'");
$plr_6_name = mysqli_fetch_assoc($player_6_name);
$player_7_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_7'");
$plr_7_name = mysqli_fetch_assoc($player_7_name);
$player_8_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_8'");
$plr_8_name = mysqli_fetch_assoc($player_8_name);
$player_9_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_9'");
$plr_9_name = mysqli_fetch_assoc($player_9_name);
$player_10_name = mysqli_query($connect, "SELECT player_f_name, player_nickname, player_l_name FROM `players` WHERE `player_id` = '$player_10'");
$plr_10_name = mysqli_fetch_assoc($player_10_name);

$game_report = mysqli_query($connect, "SELECT * FROM `game_report` WHERE `game_id` = '$game_id'");
$gm_report = mysqli_fetch_assoc($game_report);

$first_stage_team_1_sum = $gm_report['top_points_1_1'] + $gm_report['jungle_points_1_1'] + $gm_report['middle_points_1_1'] + $gm_report['carry_points_1_1'] + $gm_report['support_points_1_1'];
$first_stage_team_2_sum = $gm_report['top_points_2_1'] + $gm_report['jungle_points_2_1'] + $gm_report['middle_points_2_1'] + $gm_report['carry_points_2_1'] + $gm_report['support_points_2_1'];

$second_stage_team_1_sum = $gm_report['top_farm_1'] + $gm_report['jungle_farm_1'] + $gm_report['middle_farm_1'] + $gm_report['carry_farm_1'] + $gm_report['support_farm_1'];
$second_stage_team_2_sum = $gm_report['top_farm_2'] + $gm_report['jungle_farm_2'] + $gm_report['middle_farm_2'] + $gm_report['carry_farm_2'] + $gm_report['support_farm_2'];

$third_stage_team_1_a_sum = $gm_report['top_a_1_3'] + $gm_report['jungle_a_1_3'] + $gm_report['middle_a_1_3'] + $gm_report['carry_a_1_3'] + $gm_report['support_a_1_3'];
$third_stage_team_1_d_sum = $gm_report['top_d_1_3'] + $gm_report['jungle_d_1_3'] + $gm_report['middle_d_1_3'] + $gm_report['carry_d_1_3'] + $gm_report['support_d_1_3'];
$third_stage_team_2_a_sum = $gm_report['top_a_2_3'] + $gm_report['jungle_a_2_3'] + $gm_report['middle_a_2_3'] + $gm_report['carry_a_2_3'] + $gm_report['support_a_2_3'];
$third_stage_team_2_d_sum = $gm_report['top_d_2_3'] + $gm_report['jungle_d_2_3'] + $gm_report['middle_d_2_3'] + $gm_report['carry_d_2_3'] + $gm_report['support_d_2_3'];
$third_stage_team_1_points = $third_stage_team_1_d_sum - $third_stage_team_2_a_sum;
$third_stage_team_2_points = $third_stage_team_2_d_sum - $third_stage_team_1_a_sum;

/*
$break_status = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id'");
$brk_status = mysqli_fetch_assoc($break_status);
if ($brk_status['break_status'] == '1') {
    header('Location: /break.php');
}
*/

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/img/favicon.png" type="image/png">
    <title>Профиль команды</title>
</head>

<body>
    <div class="flex flex-nowrap bg-gray-100 min-w-max min-h-screen">
        <div class="w-1/6 bg-white rounded p-3 shadow-lg max-w-xs min-w-fit">
            <?php include "../includes/sidebar.php"; ?>
        </div>




        <div class="w-5/6">
            <div class="p-4 text-gray-500">
                <div class="max-w-screen-2xl mx-auto">
                    <div class="relative shadow-md sm:rounded-lg">
                        <div class="p-4 flex flex-row justify-between content-center border-t">
                            <?php include "../includes/topmenu.php"; ?>

                        </div>
                        <div class="p-4 flex flex-col justify-between content-center border-t">
                            <div class="flex flex-row w-full justify-around">
                                <div class="w-full bg-white/60 hover:bg-white/80 hover:shadow-lg transition duration-150 ease-linear backdrop-blur-xl right-5 top-36 rounded-lg p-6 shadow">
                                    <div class="flex flex-col">
                                        <div class="flex flex-row justify-center items-center font-bold">
                                            <?php
                                            if ($gm_info['team_1_sent_time'] > $gm_info['team_2_sent_time']) {
                                                echo $gm_info['team_1_sent_time'];
                                            } else {
                                                echo $gm_info['team_2_sent_time'];
                                            }
                                            ?>
                                        </div>
                                        <div class="flex flex-row justify-center items-center -mt-2">
                                            <?php
                                            if ($gm_info['game_type'] == 1) {
                                                echo '<p>Товарищеская игра</p>';
                                            } else {
                                                echo 'Другой тип';
                                            }
                                            ?>
                                        </div>
                                        <div class="flex flex-row justify-center items-center">
                                            <p class="text-2xl"><?php echo $tm_1_name["user_name"]; ?></p>

                                            <label class="swap swap-flip">

                                                <!-- this hidden checkbox controls the state -->
                                                <input type="checkbox" />

                                                <!-- volume on icon -->
                                                <div class="flex flex-col justify-center items-center swap-off">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                    <p class="-mt-3">Спойлер</p>
                                                </div>


                                                <p class="text-9xl mx-4 swap-on fill-current">
                                                <?php echo $gm_report["team_1_final_score"]; ?>:<?php echo $gm_report["team_2_final_score"]; ?>
                                                </p>
                                            </label>

                                            <p class="text-2xl"><?php echo $tm_2_name["user_name"]; ?></p>
                                        </div>
                                        <div class="flex flex-row justify-center items-center">
                                            <p>Зрители: <?php echo $gm_report["spectators"]; ?></p>
                                        </div>

                                        <div class="flex flex-row justify-center items-center">
                                            <table class="border border-slate-300 mt-10 mb-2 w-fit mx-10">
                                                <tbody class="border border-slate-300">
                                                    <tr class="border border-slate-300 bg-red-100">
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_1"]; ?>.png" title="<?php echo $gm_info["ban_1"]; ?>" alt="" loading="lazy"></th>
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_3"]; ?>.png" title="<?php echo $gm_info["ban_2"]; ?>" alt="" loading="lazy"></th>
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_5"]; ?>.png" title="<?php echo $gm_info["ban_3"]; ?>" alt="" loading="lazy"></th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="border border-slate-300 mt-10 mb-2 w-fit mx-10">
                                                <tbody class="border border-slate-300">
                                                    <tr class="border border-slate-300 bg-red-100">
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_2"]; ?>.png" title="<?php echo $gm_info["ban_4"]; ?>" alt="" loading="lazy"></th>
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_4"]; ?>.png" title="<?php echo $gm_info["ban_5"]; ?>" alt="" loading="lazy"></th>
                                                        <th align="center" class="border border-slate-300 px-2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["ban_6"]; ?>.png" title="<?php echo $gm_info["ban_6"]; ?>" alt="" loading="lazy"></th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="flex flex-row justify-center">
                                            <table class="border border-slate-300 mb-10 w-fit">
                                                <tbody class="border border-slate-300">
                                                    <tr class="border border-slate-300">
                                                        <th align="center" class="border border-slate-300 w-40">Игрок</th>
                                                        <th align="center" class="border border-slate-300 px-2" colspan="2">Стадия 1</th>
                                                        <th align="center" class="border border-slate-300 px-2">Стадия 2</th>
                                                        <th align="center" class="border border-slate-300 px-2" colspan="2">Стадия 3</th>
                                                        <th align="center" class="border border-slate-300"></th>
                                                        <th align="center" class="border border-slate-300 px-2" colspan="2">Стадия 3</th>
                                                        <th align="center" class="border border-slate-300 px-2">Стадия 2</th>
                                                        <th align="center" class="border border-slate-300 px-2" colspan="2">Стадия 1</th>
                                                        <th align="center" class="border border-slate-300 w-40">Игрок</th>
                                                    </tr>
                                                    <tr class="border border-slate-300">
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_1"]; ?>"><b><?php echo $plr_1_name["player_nickname"]; ?></b></a></td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_1"]; ?>.png" title="<?php echo $gm_info["hero_1"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_1"]; ?>.png" title="<?php echo $gm_info["hero_1"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300" rowspan="2">Top</td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_6"]; ?>.png" title="<?php echo $gm_info["hero_6"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_6"]; ?>.png" title="<?php echo $gm_info["hero_6"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_6"]; ?>"><b><?php echo $plr_6_name["player_nickname"]; ?></b></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["top_a_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["top_d_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["top_farm_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["top_a_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["top_d_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["top_a_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["top_d_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["top_farm_2"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["top_a_2_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["top_d_2_1"], 2, ',', ' '); ?></td>
                                                    </tr>
                                                    <tr class="border border-slate-300">
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_2"]; ?>"><b><?php echo $plr_2_name["player_nickname"]; ?></b></a></td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_2"]; ?>.png" title="<?php echo $gm_info["hero_2"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_2"]; ?>.png" title="<?php echo $gm_info["hero_2"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300" rowspan="2">Jungle</td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_7"]; ?>.png" title="<?php echo $gm_info["hero_7"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_7"]; ?>.png" title="<?php echo $gm_info["hero_7"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_7"]; ?>"><b><?php echo $plr_7_name["player_nickname"]; ?></b></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["jungle_a_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["jungle_d_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["jungle_farm_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["jungle_a_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["jungle_d_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["jungle_a_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["jungle_d_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["jungle_farm_2"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["jungle_a_2_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["jungle_d_2_1"], 2, ',', ' '); ?></td>
                                                    </tr>
                                                    <tr class="border border-slate-300">
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_3"]; ?>"><b><?php echo $plr_3_name["player_nickname"]; ?></b></a></td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_3"]; ?>.png" title="<?php echo $gm_info["hero_3"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_3"]; ?>.png" title="<?php echo $gm_info["hero_3"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300" rowspan="2">Middle</td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_8"]; ?>.png" title="<?php echo $gm_info["hero_8"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_8"]; ?>.png" title="<?php echo $gm_info["hero_8"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_8"]; ?>"><b><?php echo $plr_8_name["player_nickname"]; ?></b></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["middle_a_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["middle_d_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["middle_farm_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["middle_a_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["middle_d_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["middle_a_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["middle_d_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["middle_farm_2"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["middle_a_2_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["middle_d_2_1"], 2, ',', ' '); ?></td>
                                                    </tr>
                                                    <tr class="border border-slate-300">
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_4"]; ?>"><b><?php echo $plr_4_name["player_nickname"]; ?></b></a></td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_4"]; ?>.png" title="<?php echo $gm_info["hero_4"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_4"]; ?>.png" title="<?php echo $gm_info["hero_4"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300" rowspan="2">Carry</td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_9"]; ?>.png" title="<?php echo $gm_info["hero_9"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_9"]; ?>.png" title="<?php echo $gm_info["hero_9"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_9"]; ?>"><b><?php echo $plr_9_name["player_nickname"]; ?></b></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["carry_a_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["carry_d_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["carry_farm_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["carry_a_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["carry_d_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["carry_a_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["carry_d_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["carry_farm_2"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["carry_a_2_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["carry_d_2_1"], 2, ',', ' '); ?></td>
                                                    </tr>
                                                    <tr class="border border-slate-300">
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_5"]; ?>"><b><?php echo $plr_5_name["player_nickname"]; ?></b></a></td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_5"]; ?>.png" title="<?php echo $gm_info["hero_5"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_5"]; ?>.png" title="<?php echo $gm_info["hero_5"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300" rowspan="2">Support</td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-12 h-12 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_10"]; ?>.png" title="<?php echo $gm_info["hero_10"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <svg class="w-8 h-8 grayscale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#FFE6B8;" d="M328.116,333.78L463.709,503.83h32.681c0-53.387-24.596-101.026-63.073-132.203l-23.186,7.983  l-23.186-34.723C368.641,337.903,348.821,333.991,328.116,333.78z" />
                                                                <path style="fill:#FFF3DC;" d="M328.116,333.78c75.046,1.177,135.593,76.854,135.593,170.049H156.28  c0-53.386,24.598-101.025,63.077-132.203l23.185,11.069l23.185-37.807c18.829-7.184,39.261-11.119,60.613-11.119  C326.928,333.77,327.527,333.77,328.116,333.78z" />
                                                                <path style="fill:#FFDB9A;" d="M418.903,190.192c0-0.011-12.953-0.011-32.005,0l-60.558,113.62c26.09,0,49.718-10.578,66.821-27.681  c17.103-17.103,27.681-40.72,27.681-66.821C420.842,202.763,420.178,196.357,418.903,190.192z" />
                                                                <path style="fill:#FFE6B8;" d="M386.898,190.192c0.828,6.166,1.264,12.571,1.264,19.118c0,52.191-27.681,94.502-61.821,94.502  c-52.202,0-94.513-42.311-94.513-94.502c0-6.525,0.665-12.898,1.917-19.053l0.033-0.076c0,0,23.944,0,54.621,0  c30.666,0,68.052,0,94.938,0.011C384.545,190.192,385.732,190.192,386.898,190.192z" />
                                                                <path style="fill:#FEC45E;" d="M396.179,95.602l22.757,94.578h-32.681l-47.409-40.11l24.75-69.719l3.987-1.187  C380.209,75.373,393.085,82.77,396.179,95.602z" />
                                                                <path style="fill:#FCDB5A;" d="M371.527,95.602l14.728,94.578H233.744l24.304-94.666c3.29-12.778,16.319-20.142,28.966-16.351  l40.056,11.983l0.229,0.065l34.642-10.371l1.656-0.49C367.431,83.162,370.427,88.565,371.527,95.602z" />
                                                                <path style="fill:#594B44;" d="M81.433,179.292V503.83c0,4.513,3.657,8.17,8.17,8.17s8.17-3.657,8.17-8.17V179.292H81.433z" />
                                                                <g>
                                                                    <path style="fill:#87635C;" d="M155.43,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C163.6,3.657,159.943,0,155.43,0z" />
                                                                    <path style="fill:#87635C;" d="M23.781,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C31.951,3.657,28.294,0,23.781,0z" />
                                                                    <path style="fill:#87635C;" d="M67.664,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C75.834,3.657,72.177,0,67.664,0z" />
                                                                    <path style="fill:#87635C;" d="M111.547,0c-4.513,0-8.17,3.657-8.17,8.17v147.94h16.34V8.17C119.718,3.657,116.059,0,111.547,0z" />
                                                                </g>
                                                                <path style="fill:#FEC45E;" d="M326.336,382.252c-4.513,0-8.17-3.657-8.17-8.17v-40.307c0-4.513,3.657-8.17,8.17-8.17  c4.513,0,8.17,3.657,8.17,8.17v40.307C334.506,378.593,330.849,382.252,326.336,382.252z" />
                                                                <path style="fill:#D35B38;" d="M386.93,450.538H265.739c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17H386.93  c4.513,0,8.17-3.657,8.17-8.17C395.101,454.195,391.444,450.538,386.93,450.538z" />
                                                                <path style="fill:#FEC45E;" d="M455.309,198.355H197.058c-4.513,0-8.17-3.657-8.17-8.17s3.657-8.17,8.17-8.17h258.251  c4.513,0,8.17,3.657,8.17,8.17S459.822,198.355,455.309,198.355z" />
                                                                <path style="fill:#D35B38;" d="M130.919,145.212l-34.075,44.969h32.681c18.737,0,34.075-15.327,34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#E86F22;" d="M130.919,145.212v10.894c0,18.748-15.338,34.075-34.075,34.075H89.6H49.686  c-18.748,0-34.075-15.327-34.075-34.075v-10.894H130.919z" />
                                                                <path style="fill:#D35B38;" d="M433.315,371.625c-13.824-11.21-29.456-20.284-46.385-26.722v6.264l23.193,152.663h23.182v-1.765  C433.305,502.065,433.306,371.625,433.315,371.625z" />
                                                                <path style="fill:#E86F22;" d="M410.123,369.054V503.83H219.365v-1.765V371.636c13.813-11.22,29.445-20.295,46.363-26.744  c0.011,0.011,0.011,81.136,0.011,81.136H386.93v-74.861C395.166,356.178,402.922,362.18,410.123,369.054z" />
                                                            </svg>
                                                        </td>
                                                        <td align="center" class="border border-slate-300" colspan="2"><img class="w-8 h-8 mx-auto object-cover rounded-full" src="/heroes/<?php echo $gm_info["hero_10"]; ?>.png" title="<?php echo $gm_info["hero_10"]; ?>" alt="" loading="lazy"></td>
                                                        <td align="center" class="border border-slate-300 underline" rowspan="2"><a href="/player.php?id=<?php echo $gm_info["player_10"]; ?>"><b><?php echo $plr_10_name["player_nickname"]; ?></b></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["support_a_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["support_d_1_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["support_farm_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["support_a_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["support_d_1_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["support_a_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["support_d_2_3"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo number_format($gm_report["support_farm_2"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-red-600"><?php echo number_format($gm_report["support_a_2_1"], 2, ',', ' '); ?></td>
                                                        <td align="center" class="border border-slate-300 text-green-600"><?php echo number_format($gm_report["support_d_2_1"], 2, ',', ' '); ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex flex-col">
                                                <div class="flex flex-row">
                                                    <p>Первая стадия:</p>
                                                </div>
                                                <div class="flex flex-col active">
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_1_name["player_f_name"]; ?> "<b><?php echo $plr_1_name["player_nickname"]; ?></b>" <?php echo $plr_1_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Top</b>" за героя "<b><?php echo $gm_info["hero_1"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["top_points_1_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["top_points_1_1"], 2, ',', ' '); ?></span> очков</p>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_2_name["player_f_name"]; ?> "<b><?php echo $plr_2_name["player_nickname"]; ?></b>" <?php echo $plr_2_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Jungle</b>" за героя "<b><?php echo $gm_info["hero_2"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["jungle_points_1_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["jungle_points_1_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_3_name["player_f_name"]; ?> "<b><?php echo $plr_3_name["player_nickname"]; ?></b>" <?php echo $plr_3_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Middle</b>" за героя "<b><?php echo $gm_info["hero_3"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["middle_points_1_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["middle_points_1_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_4_name["player_f_name"]; ?> "<b><?php echo $plr_4_name["player_nickname"]; ?></b>" <?php echo $plr_4_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Carry</b>" за героя "<b><?php echo $gm_info["hero_4"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["carry_points_1_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["carry_points_1_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row pb-4">
                                                        <span>Игрок <?php echo $plr_5_name["player_f_name"]; ?> "<b><?php echo $plr_5_name["player_nickname"]; ?></b>" <?php echo $plr_5_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Support</b>" за героя "<b><?php echo $gm_info["hero_5"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["support_points_1_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["support_points_1_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_6_name["player_f_name"]; ?> "<b><?php echo $plr_6_name["player_nickname"]; ?></b>" <?php echo $plr_6_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Top</b>" за героя "<b><?php echo $gm_info["hero_6"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["top_points_2_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["top_points_2_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_7_name["player_f_name"]; ?> "<b><?php echo $plr_7_name["player_nickname"]; ?></b>" <?php echo $plr_7_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Jungle</b>" за героя "<b><?php echo $gm_info["hero_7"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["jungle_points_2_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["jungle_points_2_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_8_name["player_f_name"]; ?> "<b><?php echo $plr_8_name["player_nickname"]; ?></b>" <?php echo $plr_8_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Middle</b>" за героя "<b><?php echo $gm_info["hero_8"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["middle_points_2_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["middle_points_2_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_9_name["player_f_name"]; ?> "<b><?php echo $plr_9_name["player_nickname"]; ?></b>" <?php echo $plr_9_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Carry</b>" за героя "<b><?php echo $gm_info["hero_9"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["carry_points_2_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["carry_points_2_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_10_name["player_f_name"]; ?> "<b><?php echo $plr_10_name["player_nickname"]; ?></b>" <?php echo $plr_10_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Support</b>" за героя "<b><?php echo $gm_info["hero_10"]; ?></b>" зарабатывает <span class="
                                                            <?php
                                                            if ($gm_report["support_points_2_1"] > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($gm_report["support_points_2_1"], 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                </div>





                                                <div class="flex flex-row">
                                                    <span class="flex flex-row items-center">По итогам первой стадии со счетом
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center mx-2">
                                                                <?php echo number_format($first_stage_team_1_sum, 2, ',', ' '); ?> : <?php echo number_format($first_stage_team_2_sum, 2, ',', ' '); ?>
                                                            </span>
                                                        </label>
                                                        побеждает
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <?php
                                                            if ($first_stage_team_1_sum > $first_stage_team_2_sum) {
                                                                $first_stage_result = 1;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-rose-600">
                                                                <?php echo $tm_1_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            } else {
                                                                $first_stage_result = 2;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-indigo-600">
                                                                <?php echo $tm_2_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="flex flex-row">
                                                    <span class="flex flex-row justify-center items-center">Общий счет
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center">
                                                                <b>
                                                                    <?php
                                                                    if ($first_stage_team_1_sum > $first_stage_team_2_sum) {
                                                                    ?>
                                                                        1-0
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        0-1
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </b>
                                                            </span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>




                                            <div class="flex flex-col mt-4">
                                                <div class="flex flex-row">
                                                    <p>Вторая стадия:</p>
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_1_name["player_f_name"]; ?> "<b><?php echo $plr_1_name["player_nickname"]; ?></b>" <?php echo $plr_1_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Top</b>" за героя "<b><?php echo $gm_info["hero_1"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["top_farm_1"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_2_name["player_f_name"]; ?> "<b><?php echo $plr_2_name["player_nickname"]; ?></b>" <?php echo $plr_2_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Jungle</b>" за героя "<b><?php echo $gm_info["hero_2"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["jungle_farm_1"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_3_name["player_f_name"]; ?> "<b><?php echo $plr_3_name["player_nickname"]; ?></b>" <?php echo $plr_3_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Middle</b>" за героя "<b><?php echo $gm_info["hero_3"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["middle_farm_1"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_4_name["player_f_name"]; ?> "<b><?php echo $plr_4_name["player_nickname"]; ?></b>" <?php echo $plr_4_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Carry</b>" за героя "<b><?php echo $gm_info["hero_4"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["carry_farm_1"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row pb-4">
                                                        <span>Игрок <?php echo $plr_5_name["player_f_name"]; ?> "<b><?php echo $plr_5_name["player_nickname"]; ?></b>" <?php echo $plr_5_name["player_l_name"]; ?> из команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> играя на позиции "<b>Support</b>" за героя "<b><?php echo $gm_info["hero_5"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["support_farm_1"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_6_name["player_f_name"]; ?> "<b><?php echo $plr_6_name["player_nickname"]; ?></b>" <?php echo $plr_6_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Top</b>" за героя "<b><?php echo $gm_info["hero_6"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["top_farm_2"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_7_name["player_f_name"]; ?> "<b><?php echo $plr_7_name["player_nickname"]; ?></b>" <?php echo $plr_7_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Jungle</b>" за героя "<b><?php echo $gm_info["hero_7"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["jungle_farm_2"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_8_name["player_f_name"]; ?> "<b><?php echo $plr_8_name["player_nickname"]; ?></b>" <?php echo $plr_8_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Middle</b>" за героя "<b><?php echo $gm_info["hero_8"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["middle_farm_2"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_9_name["player_f_name"]; ?> "<b><?php echo $plr_9_name["player_nickname"]; ?></b>" <?php echo $plr_9_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Carry</b>" за героя "<b><?php echo $gm_info["hero_9"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["carry_farm_2"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>Игрок <?php echo $plr_10_name["player_f_name"]; ?> "<b><?php echo $plr_10_name["player_nickname"]; ?></b>" <?php echo $plr_10_name["player_l_name"]; ?> из команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> играя на позиции "<b>Support</b>" за героя "<b><?php echo $gm_info["hero_10"]; ?></b>" добивает <span class="text-green-600 mx-1"><?php echo number_format($gm_report["support_farm_2"], 2, ',', ' '); ?></span> крипа</span>
                                                    </div>
                                                </div>




                                                <div class="flex flex-row">
                                                    <span class="flex flex-row items-center">По итогам второй стадии со счетом
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center mx-2">
                                                                <?php echo number_format($second_stage_team_1_sum, 2, ',', ' '); ?> : <?php echo number_format($second_stage_team_2_sum, 2, ',', ' '); ?>
                                                            </span>
                                                        </label>
                                                        побеждает
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <?php
                                                            if ($second_stage_team_1_sum > $second_stage_team_2_sum) {
                                                                $second_stage_result = 1;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-rose-600">
                                                                <?php echo $tm_1_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            } else {
                                                                $second_stage_result = 2;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-indigo-600">
                                                                <?php echo $tm_2_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="flex flex-row">
                                                    <span class="flex flex-row justify-center items-center">Общий счет
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center">
                                                                <b>
                                                                    <?php
                                                                    if (($first_stage_result == 1) && ($second_stage_result == 1)) {
                                                                    ?>
                                                                        2-0
                                                                    <?php
                                                                    } elseif (($first_stage_result == 1) && ($second_stage_result == 2)) {
                                                                    ?>
                                                                        1-1
                                                                    <?php
                                                                    } elseif (($first_stage_result == 2) && ($second_stage_result == 1)) {
                                                                    ?>
                                                                        1-1
                                                                    <?php
                                                                    } else {
                                                                        ?>
                                                                            0-2
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </b>
                                                            </span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex flex-col mt-4">
                                                <div class="flex flex-row">
                                                    <p>Третья стадия:</p>
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex flex-row">
                                                        <span>В ходе третьей стадии игроки команды
                                                            <span class="text-rose-600 mx-1"><?php echo $tm_1_name["user_name"]; ?></span> общими усилиями набирают <span class="
                                                            <?php
                                                            if ($third_stage_team_1_points > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($third_stage_team_1_points, 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <span>В ходе третьей стадии игроки команды
                                                            <span class="text-indigo-600 mx-1"><?php echo $tm_2_name["user_name"]; ?></span> общими усилиями набирают <span class="
                                                            <?php
                                                            if ($third_stage_team_2_points > 0) {
                                                                echo 'text-green-600';
                                                            } else echo 'text-red-600';
                                                            ?>
                                                            mx-1"><?php echo number_format($third_stage_team_2_points, 2, ',', ' '); ?></span> очков</span>
                                                    </div>
                                                </div>
                                                <div class="flex flex-row">
                                                    <span class="flex flex-row items-center">По итогам второй стадии со счетом
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center mx-2">
                                                                <?php echo number_format($third_stage_team_1_points, 2, ',', ' '); ?> : <?php echo number_format($third_stage_team_2_points, 2, ',', ' '); ?>
                                                            </span>
                                                        </label>
                                                        побеждает
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <?php
                                                            if ($third_stage_team_1_points > $third_stage_team_2_points) {
                                                                $third_stage_result = 1;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-rose-600">
                                                                <?php echo $tm_1_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            } else {
                                                                $third_stage_result = 2;
                                                            ?>
                                                                <span class="swap-on fill-current flex justify-center items-center mx-6 text-indigo-600">
                                                                <?php echo $tm_2_name["user_name"]; ?>
                                                                </span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="flex flex-row">
                                                    <span class="flex flex-row justify-center items-center">Общий счет
                                                        <label class="swap swap-flip">
                                                            <!-- this hidden checkbox controls the state -->
                                                            <input type="checkbox" />
                                                            <!-- volume on icon -->
                                                            <div class="flex flex-col justify-center items-center mx-2 swap-off">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                                <span class="-mt-1 text-sm">Спойлер</span>
                                                            </div>
                                                            <span class="swap-on fill-current flex justify-center items-center">
                                                                <b>
                                                                    <?php
                                                                    if ($third_stage_result == 1) {
                                                                    ?>
                                                                        2-1
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        1-2
                                                                    <?php
                                                                    } 
                                                                    ?>
                                                                </b>
                                                            </span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-row mt-10 justify-center">
                                            <div class="flex flex-col">
                                                <table>
                                                    <tbody>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Top</td>
                                                            <td>
                                                                <?php echo $plr_1_name["player_f_name"]; ?> "<b><?php echo $plr_1_name["player_nickname"]; ?></b>" <?php echo $plr_1_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_1_exp"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="w-24">Jungle</td>
                                                            <td>
                                                                <?php echo $plr_2_name["player_f_name"]; ?> "<b><?php echo $plr_2_name["player_nickname"]; ?></b>" <?php echo $plr_2_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_2_exp"]; ?></td>
                                                        </tr>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Middle</td>
                                                            <td>
                                                                <?php echo $plr_3_name["player_f_name"]; ?> "<b><?php echo $plr_3_name["player_nickname"]; ?></b>" <?php echo $plr_3_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_3_exp"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="w-24">Carry</td>
                                                            <td>
                                                                <?php echo $plr_4_name["player_f_name"]; ?> "<b><?php echo $plr_4_name["player_nickname"]; ?></b>" <?php echo $plr_4_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_4_exp"]; ?></td>
                                                        </tr>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Support</td>
                                                            <td>
                                                                <?php echo $plr_5_name["player_f_name"]; ?> "<b><?php echo $plr_5_name["player_nickname"]; ?></b>" <?php echo $plr_5_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_5_exp"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="flex flex-col mx-5">
                                                <div class="flex flex-row justify-between">
                                                    <span class="text-rose-600"><?php echo $tm_1_name["user_name"]; ?></span>
                                                    <span class="text-indigo-600"><?php echo $tm_2_name["user_name"]; ?></span>
                                                </div>
                                                <table class="border border-slate-300">
                                                    <tbody class="border border-slate-300">
                                                        <tr class="border border-slate-300">
                                                            <td align="center" class="border border-slate-300"><?php echo $gm_report["avg_power_team_1"]; ?></td>
                                                            <td align="center" class="border border-slate-300">Средняя сила команды</td>
                                                            <td align="center" class="border border-slate-300"><?php echo $gm_report["avg_power_team_2"]; ?></td>
                                                        </tr>
                                                        <tr class="border border-slate-300">
                                                            <td align="center" class="border border-slate-300"><?php echo $gm_report["avg_power_five_1"]; ?></td>
                                                            <td align="center" class="border border-slate-300"> Средняя сила основы</td>
                                                            <td align="center" class="border border-slate-300"><?php echo $gm_report["avg_power_five_2"]; ?></td>
                                                        </tr>
                                                        <tr class="border border-slate-300">
                                                            <td align="center" class="border border-slate-300">
                                                                <?php
                                                                if ($gm_info["jungle_a_1"] == 1) {
                                                                    echo 'Top';
                                                                } elseif ($gm_info["jungle_a_1"] == 3) {
                                                                    echo 'Middle';
                                                                } elseif ($gm_info["jungle_a_1"] == 4) {
                                                                    echo 'Carry';
                                                                } elseif ($gm_info["jungle_a_1"] == 5) {
                                                                    echo 'Support';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="center" class="border border-slate-300">Атака джанглера</td>
                                                            <td align="center" class="border border-slate-300">
                                                                <?php
                                                                if ($gm_info["jungle_a_2"] == 1) {
                                                                    echo 'Top';
                                                                } elseif ($gm_info["jungle_a_2"] == 3) {
                                                                    echo 'Middle';
                                                                } elseif ($gm_info["jungle_a_2"] == 4) {
                                                                    echo 'Carry';
                                                                } elseif ($gm_info["jungle_a_2"] == 5) {
                                                                    echo 'Support';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border border-slate-300">
                                                            <td align="center" class="border border-slate-300">
                                                                <?php
                                                                if ($gm_info["jungle_d_1"] == 1) {
                                                                    echo 'Top';
                                                                } elseif ($gm_info["jungle_d_1"] == 3) {
                                                                    echo 'Middle';
                                                                } elseif ($gm_info["jungle_d_1"] == 4) {
                                                                    echo 'Carry';
                                                                } elseif ($gm_info["jungle_d_1"] == 5) {
                                                                    echo 'Support';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="center" class="border border-slate-300">Защита джанглера</td>
                                                            <td align="center" class="border border-slate-300">
                                                                <?php
                                                                if ($gm_info["jungle_d_2"] == 1) {
                                                                    echo 'Top';
                                                                } elseif ($gm_info["jungle_d_2"] == 3) {
                                                                    echo 'Middle';
                                                                } elseif ($gm_info["jungle_d_2"] == 4) {
                                                                    echo 'Carry';
                                                                } elseif ($gm_info["jungle_d_2"] == 5) {
                                                                    echo 'Support';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="flex flex-col">
                                                <table>
                                                    <tbody>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Top</td>
                                                            <td>
                                                                <?php echo $plr_6_name["player_f_name"]; ?> "<b><?php echo $plr_6_name["player_nickname"]; ?></b>" <?php echo $plr_6_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_6_exp"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="w-24">Jungle</td>
                                                            <td>
                                                                <?php echo $plr_7_name["player_f_name"]; ?> "<b><?php echo $plr_7_name["player_nickname"]; ?></b>" <?php echo $plr_7_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_7_exp"]; ?></td>
                                                        </tr>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Middle</td>
                                                            <td>
                                                                <?php echo $plr_8_name["player_f_name"]; ?> "<b><?php echo $plr_8_name["player_nickname"]; ?></b>" <?php echo $plr_8_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_8_exp"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="w-24">Carry</td>
                                                            <td>
                                                                <?php echo $plr_9_name["player_f_name"]; ?> "<b><?php echo $plr_9_name["player_nickname"]; ?></b>" <?php echo $plr_9_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_9_exp"]; ?></td>
                                                        </tr>
                                                        <tr class="bg-slate-100">
                                                            <td align="center" class="w-24">Support</td>
                                                            <td>
                                                                <?php echo $plr_10_name["player_f_name"]; ?> "<b><?php echo $plr_10_name["player_nickname"]; ?></b>" <?php echo $plr_10_name["player_l_name"]; ?>
                                                            </td>
                                                            <td align="center" class="w-24"><?php echo $gm_report["player_10_exp"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var block_show = false;

        function scrollTracking() {
            if (block_show) {
                return false;
            }

            var wt = $(window).scrollTop();
            var wh = $(window).height();
            var et = $('.active').offset().top;
            var eh = $('.active').outerHeight();
            var dh = $(document).height();


            if (et >= wt && et + eh <= wh + wt) {
                if (block_show == null || block_show == false) {
                    $('.active div:eq(0)').show('slow', function() {
                        $(this).next().show('slow', arguments.callee);
                    });
                }
                block_show = true;
            } else {
                if (block_show == null || block_show == true) {
                    $('.active div:eq(0)').html('');
                }
                block_show = false;
            }
        }


        $(window).scroll(function() {
            scrollTracking();
        });

        $(document).ready(function() {
            scrollTracking();
        });
    </script>

    <style type="text/css">
        .active {
            overflow: hidden;
        }

        .active div {
            display: none;
        }
    </style>

</body>



</html>