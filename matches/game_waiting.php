<?php
session_start();
require_once '../config/connect.php';
require_once '../vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];
$game_id = (intval($_GET['game_id']));

$opponent_awaiting = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
$oppnnt_awaiting = mysqli_fetch_assoc($opponent_awaiting);
$actual_game_phase = $oppnnt_awaiting['phase'];

$team_1_id = $oppnnt_awaiting['user_1'];
$team_2_id = $oppnnt_awaiting['user_2'];

$team_1_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$team_1_id'");
$tm_1_name = mysqli_fetch_assoc($team_1_name);

$team_2_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$team_2_id'");
$tm_2_name = mysqli_fetch_assoc($team_2_name);


/*--------------------------------Проверка на состоявшийся матч--------------------------------*/
$game_done_check = mysqli_query($connect, "SELECT SUM(game_id) as game_id_sum FROM `game_report` WHERE `game_id` = '$game_id'");
$gm_done_check = mysqli_fetch_assoc($game_done_check);
$gm_dn_check = $gm_done_check['game_id_sum'];

//Если матч состоялся, то со страницы gane_waiting.php будет перенаправлять на страницу game_report.php

if ($gm_dn_check > 0) {
    header('Location: /matches/game_report.php?game_id=' . $game_id);
}
/*-----------------------------------------------------------------------------------------------*/

/*--------------------------------Проверка на участвующих в матче--------------------------------*/
if (($oppnnt_awaiting['user_1'] != $user_id) && ($oppnnt_awaiting['user_2'] != $user_id)) {
    header('Location: ../team.php?id=' . $user_id);
}
/*-----------------------------------------------------------------------------------------------*/

/*--------------------------------Если Участник еще не распределил игроков и героев, то его отправляет на ту фазу, где сейчас происходят пики/баны--------------------------------*/
if (($oppnnt_awaiting['player_1'] < 1) && ($oppnnt_awaiting['player_6'] < 1) && ($oppnnt_awaiting['game_id'] == $game_id)) {
    header('Location: /matches/prematch_stage.php?game_id=' . $game_id . '&phase=' . $actual_game_phase);
}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (($oppnnt_awaiting['user_1'] == $user_id) && ($oppnnt_awaiting['player_1'] > 1) && ($oppnnt_awaiting['player_6'] < 1)) {
    $url = 'game_waiting.php?game_id=' . $game_id;
    $sec = "5";
    header("Refresh: $sec; url=$url");
} elseif (($oppnnt_awaiting['user_2'] == $user_id) && ($oppnnt_awaiting['player_6'] > 1) && ($oppnnt_awaiting['player_1'] < 1)) {
    $url = 'game_waiting.php?game_id=' . $game_id;
    $sec = "5";
    header("Refresh: $sec; url=$url");
} elseif (($oppnnt_awaiting['user_1'] == $user_id) && ($oppnnt_awaiting['player_1'] > 1) && ($oppnnt_awaiting['player_6'] > 1)) {
    $url = 'game_report.php?game_id=' . $game_id;
    $sec = "5";
    header("Refresh: $sec; url=$url");
} elseif (($oppnnt_awaiting['user_2'] == $user_id) && ($oppnnt_awaiting['player_6'] > 1) && ($oppnnt_awaiting['player_1'] > 1)) {
    $url = 'game_report.php?game_id=' . $game_id;
    $sec = "5";
    header("Refresh: $sec; url=$url");
}

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
                                    <?php
                                    if (($oppnnt_awaiting['player_1'] < 1) || ($oppnnt_awaiting['player_6'] < 1)) {
                                    ?>
                                        <h1 class="text-xl text-slate-700 font-medium mb-12 flex justify-center">ОЖИДАНИЕ СОПЕРНИКА</h1>
                                    <?php
                                    }
                                    ?>
                                    <div class="flex flex-col">

                                        <?php
                                        if (($oppnnt_awaiting['player_1'] > 1) && ($oppnnt_awaiting['player_6'] < 1)) {
                                        ?>

                                            <div class="grid gap-12 items-center md:grid-cols-5">
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                
<?php
                                            if ($oppnnt_awaiting['captain_1'] == $oppnnt_awaiting['player_1']) {
?>
w-52 h-32
<?php
                                            } else {
?>
w-32 h-32
<?php
                                            }
?>

                                                mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_1"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_1"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_1"]; ?></h4>

                                                        <?php
                                                        $player_1_info = $oppnnt_awaiting['player_1'];
                                                        $players_id_info_1 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_1_info'");
                                                        $plrs_id_info_1 = mysqli_fetch_assoc($players_id_info_1);
                                                        ?>
                                                        <span class="block text-sm text-rose-600"><?php echo $plrs_id_info_1["player_f_name"]; ?> "<?php echo $plrs_id_info_1["player_nickname"]; ?>" <?php echo $plrs_id_info_1["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                <?php
                                                if ($oppnnt_awaiting['captain_1'] == $oppnnt_awaiting['player_2']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_2"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_2"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_2"]; ?></h4>

                                                        <?php
                                                        $player_2_info = $oppnnt_awaiting['player_2'];
                                                        $players_id_info_2 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_2_info'");
                                                        $plrs_id_info_2 = mysqli_fetch_assoc($players_id_info_2);
                                                        ?>
                                                        <span class="block text-sm text-rose-600"><?php echo $plrs_id_info_2["player_f_name"]; ?> "<?php echo $plrs_id_info_2["player_nickname"]; ?>" <?php echo $plrs_id_info_2["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                <?php
                                                if ($oppnnt_awaiting['captain_1'] == $oppnnt_awaiting['player_3']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_3"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_3"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_3"]; ?></h4>

                                                        <?php
                                                        $player_3_info = $oppnnt_awaiting['player_3'];
                                                        $players_id_info_3 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_3_info'");
                                                        $plrs_id_info_3 = mysqli_fetch_assoc($players_id_info_3);
                                                        ?>
                                                        <span class="block text-sm text-rose-600"><?php echo $plrs_id_info_3["player_f_name"]; ?> "<?php echo $plrs_id_info_3["player_nickname"]; ?>" <?php echo $plrs_id_info_3["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="
                                                <?php
                                                if ($oppnnt_awaiting['captain_1'] == $oppnnt_awaiting['player_4']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_4"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_4"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_4"]; ?></h4>


                                                        <?php
                                                        $player_4_info = $oppnnt_awaiting['player_4'];
                                                        $players_id_info_4 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_4_info'");
                                                        $plrs_id_info_4 = mysqli_fetch_assoc($players_id_info_4);
                                                        ?>
                                                        <span class="block text-sm text-rose-600"><?php echo $plrs_id_info_4["player_f_name"]; ?> "<?php echo $plrs_id_info_4["player_nickname"]; ?>" <?php echo $plrs_id_info_4["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="<?php if ($oppnnt_awaiting['captain_1'] == $oppnnt_awaiting['player_5']) {
                                                                ?>
                                                w-52 h-32
                                                <?php
                                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_5"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_5"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_5"]; ?></h4>

                                                        <?php
                                                        $player_5_info = $oppnnt_awaiting['player_5'];
                                                        $players_id_info_5 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_5_info'");
                                                        $plrs_id_info_5 = mysqli_fetch_assoc($players_id_info_5);
                                                        ?>
                                                        <span class="block text-sm text-rose-600"><?php echo $plrs_id_info_5["player_f_name"]; ?> "<?php echo $plrs_id_info_5["player_nickname"]; ?>" <?php echo $plrs_id_info_5["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row justify-center my-10 items-center">
                                                <p class="text-rose-600 font-bold"><?php echo $tm_1_name["user_name"]; ?></p>
                                                <p class="text-2xl mx-5">vs</p>
                                                <p class="text-indigo-600 font-bold"><?php echo $tm_2_name["user_name"]; ?></p>
                                            </div>


                                            <div class="grid gap-12 items-center md:grid-cols-5">
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_2"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_2"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_2"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_4"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_4"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_4"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_6"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_6"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_6"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_8"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_8"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_8"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_10"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_10"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_10"]; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } elseif (($oppnnt_awaiting['player_1'] < 1) && ($oppnnt_awaiting['player_6'] > 1)) {
                                        ?>

                                            <div class="grid gap-12 items-center md:grid-cols-5">
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_1"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_1"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_1"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_3"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_3"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_3"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_5"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_5"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_5"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_7"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_7"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_7"]; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="w-32 h-32 mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["pick_9"]; ?>.png" alt="<?php echo $oppnnt_awaiting["pick_9"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["pick_9"]; ?></h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex flex-row justify-center my-10 items-center">
                                                <p class="text-rose-600 font-bold"><?php echo $tm_1_name["user_name"]; ?></p>
                                                <p class="text-2xl mx-5">vs</p>
                                                <p class="text-indigo-600 font-bold"><?php echo $tm_2_name["user_name"]; ?></p>
                                            </div>

                                            <div class="grid gap-12 items-center md:grid-cols-5">
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                
<?php
                                            if ($oppnnt_awaiting['captain_2'] == $oppnnt_awaiting['player_6']) {
?>
w-52 h-32
<?php
                                            } else {
?>
w-32 h-32
<?php
                                            }
?>

                                                mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_6"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_6"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_6"]; ?></h4>

                                                        <?php
                                                        $player_6_info = $oppnnt_awaiting['player_6'];
                                                        $players_id_info_6 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_6_info'");
                                                        $plrs_id_info_6 = mysqli_fetch_assoc($players_id_info_6);
                                                        ?>
                                                        <span class="block text-sm text-indigo-600"><?php echo $plrs_id_info_6["player_f_name"]; ?> "<?php echo $plrs_id_info_6["player_nickname"]; ?>" <?php echo $plrs_id_info_6["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                <?php
                                                if ($oppnnt_awaiting['captain_2'] == $oppnnt_awaiting['player_7']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_7"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_7"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_7"]; ?></h4>

                                                        <?php
                                                        $player_7_info = $oppnnt_awaiting['player_7'];
                                                        $players_id_info_7 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_7_info'");
                                                        $plrs_id_info_7 = mysqli_fetch_assoc($players_id_info_7);
                                                        ?>
                                                        <span class="block text-sm text-indigo-600"><?php echo $plrs_id_info_7["player_f_name"]; ?> "<?php echo $plrs_id_info_7["player_nickname"]; ?>" <?php echo $plrs_id_info_7["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class=" 
                                                <?php
                                                if ($oppnnt_awaiting['captain_2'] == $oppnnt_awaiting['player_8']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_8"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_8"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_8"]; ?></h4>

                                                        <?php
                                                        $player_8_info = $oppnnt_awaiting['player_8'];
                                                        $players_id_info_8 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_8_info'");
                                                        $plrs_id_info_8 = mysqli_fetch_assoc($players_id_info_8);
                                                        ?>
                                                        <span class="block text-sm text-indigo-600"><?php echo $plrs_id_info_8["player_f_name"]; ?> "<?php echo $plrs_id_info_8["player_nickname"]; ?>" <?php echo $plrs_id_info_8["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="
                                                <?php
                                                if ($oppnnt_awaiting['captain_2'] == $oppnnt_awaiting['player_9']) {
                                                ?>
                                                w-52 h-32
                                                <?php
                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_9"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_9"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_9"]; ?></h4>


                                                        <?php
                                                        $player_9_info = $oppnnt_awaiting['player_9'];
                                                        $players_id_info_9 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_9_info'");
                                                        $plrs_id_info_9 = mysqli_fetch_assoc($players_id_info_9);
                                                        ?>
                                                        <span class="block text-sm text-indigo-600"><?php echo $plrs_id_info_9["player_f_name"]; ?> "<?php echo $plrs_id_info_9["player_nickname"]; ?>" <?php echo $plrs_id_info_9["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-4 text-center">
                                                    <img class="<?php if ($oppnnt_awaiting['captain_2'] == $oppnnt_awaiting['player_10']) {
                                                                ?>
                                                w-52 h-32
                                                <?php
                                                                } else {
                                                ?>
                                                w-32 h-32
                                                <?php
                                                                }
                                                ?> mx-auto object-cover rounded-xl" src="/heroes/<?php echo $oppnnt_awaiting["hero_10"]; ?>.png" alt="<?php echo $oppnnt_awaiting["hero_10"]; ?>" loading="lazy" width="640" height="805">
                                                    <div>
                                                        <h4 class="text-2xl"><?php echo $oppnnt_awaiting["hero_10"]; ?></h4>

                                                        <?php
                                                        $player_10_info = $oppnnt_awaiting['player_10'];
                                                        $players_id_info_10 = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_10_info'");
                                                        $plrs_id_info_10 = mysqli_fetch_assoc($players_id_info_10);
                                                        ?>
                                                        <span class="block text-sm text-indigo-600"><?php echo $plrs_id_info_10["player_f_name"]; ?> "<?php echo $plrs_id_info_10["player_nickname"]; ?>" <?php echo $plrs_id_info_10["player_l_name"]; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } elseif (($oppnnt_awaiting['player_1'] > 0) && ($oppnnt_awaiting['player_6'] > 0) && ($gm_dn_check < 1)) {
                                        ?>
                                            <div class="flex flex-col w-full h-64 justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                                <p>Идет генерация матча</p>
                                            </div>

                                        <?php
                                            include "../match_generation.php";
                                            mysqli_query($connect, "INSERT INTO `game_report` 
                                        (`game_id`, 
                                        `top_a_1_1`, 
                                        `top_d_1_1`, 
                                        `jungle_a_1_1`, 
                                        `jungle_d_1_1`,
                                        `middle_a_1_1`,
                                        `middle_d_1_1`,
                                        `carry_a_1_1`,
                                        `carry_d_1_1`,
                                        `support_a_1_1`,
                                        `support_d_1_1`,
                                        `top_a_2_1`,
                                        `top_d_2_1`,
                                        `jungle_a_2_1`,
                                        `jungle_d_2_1`,
                                        `middle_a_2_1`,
                                        `middle_d_2_1`,
                                        `carry_a_2_1`,
                                        `carry_d_2_1`,
                                        `support_a_2_1`,
                                        `support_d_2_1`,
                                        `top_farm_1`,
                                        `jungle_farm_1`,
                                        `middle_farm_1`,
                                        `carry_farm_1`,
                                        `support_farm_1`,
                                        `top_farm_2`,
                                        `jungle_farm_2`,
                                        `middle_farm_2`,
                                        `carry_farm_2`,
                                        `support_farm_2`,
                                        `top_a_1_3`,
                                        `top_d_1_3`,
                                        `jungle_a_1_3`,
                                        `jungle_d_1_3`,
                                        `middle_a_1_3`,
                                        `middle_d_1_3`,
                                        `carry_a_1_3`,
                                        `carry_d_1_3`,
                                        `support_a_1_3`,
                                        `support_d_1_3`,
                                        `top_a_2_3`,
                                        `top_d_2_3`,
                                        `jungle_a_2_3`,
                                        `jungle_d_2_3`,
                                        `middle_a_2_3`,
                                        `middle_d_2_3`,
                                        `carry_a_2_3`,
                                        `carry_d_2_3`,
                                        `support_a_2_3`,
                                        `support_d_2_3`,
                                        `top_points_1_1`,
                                        `jungle_points_1_1`,
                                        `middle_points_1_1`,
                                        `carry_points_1_1`,
                                        `support_points_1_1`,
                                        `top_points_2_1`,
                                        `jungle_points_2_1`,
                                        `middle_points_2_1`,
                                        `carry_points_2_1`,
                                        `support_points_2_1`,
                                        `player_1_exp`,
                                        `player_2_exp`,
                                        `player_3_exp`,
                                        `player_4_exp`,
                                        `player_5_exp`,
                                        `player_6_exp`,
                                        `player_7_exp`,
                                        `player_8_exp`,
                                        `player_9_exp`,
                                        `player_10_exp`,
                                        `player_hero_1_exp`,
                                        `player_hero_2_exp`,
                                        `player_hero_3_exp`,
                                        `player_hero_4_exp`,
                                        `player_hero_5_exp`,
                                        `player_hero_6_exp`,
                                        `player_hero_7_exp`,
                                        `player_hero_8_exp`,
                                        `player_hero_9_exp`,
                                        `player_hero_10_exp`,
                                        `avg_power_team_1`,
                                        `avg_power_five_1`,
                                        `avg_power_team_2`,
                                        `avg_power_five_2`,
                                        `spectators`,
                                        `team_1_final_score`,
                                        `team_2_final_score`) 
                                        VALUES 
                                        ('$game_id', 
                                        '$top_a_1_1', 
                                        '$top_d_1_1', 
                                        '$jungle_a_1_1', 
                                        '$jungle_d_1_1',
                                        '$middle_a_1_1',
                                        '$middle_d_1_1',
                                        '$carry_a_1_1',
                                        '$carry_d_1_1',
                                        '$support_a_1_1',
                                        '$support_d_1_1',
                                        '$top_a_2_1',
                                        '$top_d_2_1',
                                        '$jungle_a_2_1',
                                        '$jungle_d_2_1',
                                        '$middle_a_2_1',
                                        '$middle_d_2_1',
                                        '$carry_a_2_1',
                                        '$carry_d_2_1',
                                        '$support_a_2_1',
                                        '$support_d_2_1',
                                        '$top_farm_1',
                                        '$jungle_farm_1',
                                        '$middle_farm_1',
                                        '$carry_farm_1',
                                        '$support_farm_1',
                                        '$top_farm_2',
                                        '$jungle_farm_2',
                                        '$middle_farm_2',
                                        '$carry_farm_2',
                                        '$support_farm_2',
                                        '$top_a_1_3',
                                        '$top_d_1_3',
                                        '$jungle_a_1_3',
                                        '$jungle_d_1_3',
                                        '$middle_a_1_3',
                                        '$middle_d_1_3',
                                        '$carry_a_1_3',
                                        '$carry_d_1_3',
                                        '$support_a_1_3',
                                        '$support_d_1_3',
                                        '$top_a_2_3',
                                        '$top_d_2_3',
                                        '$jungle_a_2_3',
                                        '$jungle_d_2_3',
                                        '$middle_a_2_3',
                                        '$middle_d_2_3',
                                        '$carry_a_2_3',
                                        '$carry_d_2_3',
                                        '$support_a_2_3',
                                        '$support_d_2_3',
                                        '$top_points_1_1',
                                        '$jungle_points_1_1',
                                        '$middle_points_1_1',
                                        '$carry_points_1_1',
                                        '$support_points_1_1',
                                        '$top_points_2_1',
                                        '$jungle_points_2_1',
                                        '$middle_points_2_1',
                                        '$carry_points_2_1',
                                        '$support_points_2_1',
                                        '$player_1_exp',
                                        '$player_2_exp',
                                        '$player_3_exp',
                                        '$player_4_exp',
                                        '$player_5_exp',
                                        '$player_6_exp',
                                        '$player_7_exp',
                                        '$player_8_exp',
                                        '$player_9_exp',
                                        '$player_10_exp',
                                        '$player_hero_1_exp',
                                        '$player_hero_2_exp',
                                        '$player_hero_3_exp',
                                        '$player_hero_4_exp',
                                        '$player_hero_5_exp',
                                        '$player_hero_6_exp',
                                        '$player_hero_7_exp',
                                        '$player_hero_8_exp',
                                        '$player_hero_9_exp',
                                        '$player_hero_10_exp',
                                        '$avg_power_team_1',
                                        '$avg_power_five_1',
                                        '$avg_power_team_2',
                                        '$avg_power_five_2',
                                        '$spectators',
                                        '$team_1_final_score',
                                        '$team_2_final_score')");
                                            mysqli_query($connect, "UPDATE `games` SET `phase` = 18 WHERE `game_id` = '$game_id'");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>