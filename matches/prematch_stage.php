<?php
session_start();
require_once '../config/connect.php';


if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

/*-----------------------------------------------------------------*/
// Проверить на пустые получаемые значения из урл
// Забаненные и пикнутые герои не пропадают из списка на бан и на выбор;
/*-----------------------------------------------------------------*/


$user_id = $_SESSION['user']['user_id'];

$phase = (intval($_GET['phase']));
$game_id = (intval($_GET['game_id']));

$prematch_info = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
$prmtch_info = mysqli_fetch_assoc($prematch_info);
$actual_game_phase = $prmtch_info['phase'];

$hero_full_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`");
$hr_full_list = mysqli_fetch_assoc($hero_full_list);


/*--------------------------------Проверка на участвующих в матче--------------------------------*/
if (($prmtch_info['user_1'] != $user_id) && ($prmtch_info['user_2'] != $user_id)) {
    header('Location: ../team.php?id=' . $user_id);
}
/*-----------------------------------------------------------------------------------------------*/


/*-----------------------------------Проверка отправку состава-----------------------------------*/
if ($prmtch_info['user_1'] == $user_id) {
    if ($prmtch_info['player_1'] > 1) {
        header('Location: game_waiting.php?game_id=' . $game_id);
    }
} elseif ($prmtch_info['user_2'] == $user_id) {
    if ($prmtch_info['player_6'] > 1) {
        header('Location: game_waiting.php?game_id=' . $game_id);
    }
}
/*-----------------------------------------------------------------------------------------------*/


/*------------------------------------Проверка введенной фазы------------------------------------*/
if ($phase != $prmtch_info['phase']) {
    header('Location: /matches/prematch_stage.php?game_id=' . $game_id . '&phase=' . $actual_game_phase);
}
/*-----------------------------------------------------------------------------------------------*/


/*-------------------Обновление страницы во время ожидания действий соперника--------------------*/
if ($prmtch_info['user_1'] == $user_id) {
    if ($phase == '2' || $phase == '4' || $phase == '6' || $phase == '8' || $phase == '10' || $phase == '12' || $phase == '14' || $phase == '16') {

        $game_phase = $prmtch_info['phase'];
        $url = 'prematch_stage.php?game_id=' . $game_id . '&phase=' . $game_phase;
        $sec = "5";
        header("Refresh: $sec; url=$url");
    }
} elseif ($prmtch_info['user_2'] == $user_id) {
    if ($phase == '1' || $phase == '3' || $phase == '5' || $phase == '7' || $phase == '9' || $phase == '11' || $phase == '13' || $phase == '15') {

        $game_phase = $prmtch_info['phase'];
        $url = 'prematch_stage.php?game_id=' . $game_id . '&phase=' . $game_phase;
        $sec = "5";
        header("Refresh: $sec; url=$url");
    }
}
/*-----------------------------------------------------------------------------------------------*/


$heroes_ban_pick_list = mysqli_query($connect, "SELECT ban_1, ban_2, ban_3, ban_4, ban_5, ban_6, pick_1, pick_2, pick_3, pick_4, pick_5, pick_6, pick_7, pick_8, pick_9, pick_10 FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
$hrs_ban_pick_list = mysqli_fetch_assoc($heroes_ban_pick_list);
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
                        <div class="p-4 flex flex-row justify-between content-center border-t flex-wrap">
                            <div class="w-full bg-white/60 hover:bg-white/80 hover:shadow-lg transition duration-150 ease-linear backdrop-blur-xl right-5 top-36 rounded-lg p-6 shadow flex flex-col justify-center">
                                <div class="flex flex-row justify-center items-center">

                                </div>
                                <?php
                                if ($phase == 1) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg" src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=1" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_1" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control bp-list mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                            ?>
                                                                <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </form>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg" src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 2) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if ($hrs_list["hero_name"] == $hr_pick_left['ban_1']) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if ($hrs_list["hero_name"] == $hr_pick_left['ban_1']) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=2" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_2" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control bp-list" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control bp-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 3) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=3" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_3" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 4) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=4" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_4" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 5) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_4"]; ?>"><?php echo $hro_ban_1["ban_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=5" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_5" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                    </form>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_4"]; ?>"><?php echo $hro_ban_1["ban_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-gray-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 6) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_4"]; ?>"><?php echo $hro_ban_1["ban_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_5"]; ?>"><?php echo $hro_ban_1["ban_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_6" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ БАНОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_ban_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_ban_1 = mysqli_fetch_assoc($hero_ban_1)
                                                        ?>
                                                        <option value="<?php echo $hro_ban_1["ban_1"]; ?>"><?php echo $hro_ban_1["ban_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_2"]; ?>"><?php echo $hro_ban_1["ban_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_3"]; ?>"><?php echo $hro_ban_1["ban_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <select type="text" name="ban_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_4"]; ?>"><?php echo $hro_ban_1["ban_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Бан 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="ban_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_ban_1["ban_5"]; ?>"><?php echo $hro_ban_1["ban_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=6" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="ban_6" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 7) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=7" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_1" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 8) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick_1 = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick_1 = mysqli_fetch_assoc($hero_pick_1)
                                                        ?>
                                                        <option value="<?php echo $hro_pick_1["pick_1"]; ?>"><?php echo $hro_pick_1["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=8" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_2" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 9) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=9" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_3" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 10) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=10" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_4" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 11) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=11" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_5" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 12) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=12" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_6" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 13) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=13" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_7" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 14) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=14" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_8" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 15) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_8"]; ?>"><?php echo $hro_pick["pick_8"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=15" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_9" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_8"]; ?>"><?php echo $hro_pick["pick_8"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 16) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_9'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick)
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_8"]; ?>"><?php echo $hro_pick["pick_8"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_9"]; ?>"><?php echo $hro_pick["pick_9"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_10" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value=""></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_9'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/3 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">СТАДИЯ ПИКОВ</h1>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 1</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_1" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <?php
                                                        $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                        $hro_pick = mysqli_fetch_assoc($hero_pick);
                                                        ?>
                                                        <option value="<?php echo $hro_pick["pick_1"]; ?>"><?php echo $hro_pick["pick_1"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_2" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_2"]; ?>"><?php echo $hro_pick["pick_2"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 2</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_3" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_3"]; ?>"><?php echo $hro_pick["pick_3"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_4" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_4"]; ?>"><?php echo $hro_pick["pick_4"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 3</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_5" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_5"]; ?>"><?php echo $hro_pick["pick_5"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_6" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_6"]; ?>"><?php echo $hro_pick["pick_6"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 4</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_7" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_7"]; ?>"><?php echo $hro_pick["pick_7"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select type="text" name="pick_8" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-indigo-600 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_8"]; ?>"><?php echo $hro_pick["pick_8"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <p>Пик 5</p>
                                                </div>
                                                <div class="flex flex-row justify-center items-center">
                                                    <select type="text" name="pick_9" class="h-10 border rounded px-4 w-40 bg-red-50 mt-1 form-control db-list border-2 border-rose-600 mr-6 appearance-none" disabled value="">
                                                        <option value="<?php echo $hro_pick["pick_9"]; ?>"><?php echo $hro_pick["pick_9"]; ?></option>
                                                        <?php
                                                        $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                        while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                        ?>
                                                            <option value='<?php echo $hrs_list["hero_name"]; ?>'><?php echo $hrs_list["hero_name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=16" method="post" class="" enctype="multipart/form-data">
                                                        <select type="text" name="pick_10" onchange="this.form.submit();" class="h-10 border rounded px-4 w-40 bg-green-50 mt-1 form-control db-list border-2 border-indigo-600 " value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                            while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                                $result = array_diff($hrs_list, $hrs_ban_pick_list);
                                                                if(!empty($result['hero_name'])) {
                                                            ?>
                                                                <option value='<?php echo $result['hero_name']; ?>'><?php echo $result['hero_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                } elseif ($phase == 17) {
                                    if ($prmtch_info['user_1'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_9'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_10'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/2 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">ПЛАНИРОВАНИЕ</h1>

                                                <?php
                                                if (isset($_SESSION['player_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['player_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['player_select_error']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['jungle_stats_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['jungle_stats_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['jungle_stats_select_error']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['hero_select_error_1'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['hero_select_error_1'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['hero_select_error_1']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['hero_select_error_2'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['hero_select_error_2'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['hero_select_error_2']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['captain_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['captain_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['captain_select_error']);
                                                ?>




                                                <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=17" method="post" class="" enctype="multipart/form-data">
                                                    <div id="fields-list" class="div">
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Top:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_1" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <?php
                                                                $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                                $hro_pick = mysqli_fetch_assoc($hero_pick);
                                                                $user_1 = $hro_pick['user_1'];
                                                                ?>
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_1" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $hero_list = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                                $hr_list = mysqli_fetch_assoc($hero_list)
                                                                ?>
                                                                <option value='<?php echo $hr_list["pick_1"]; ?>'><?php echo $hr_list["pick_1"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_3"]; ?>'><?php echo $hr_list["pick_3"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_5"]; ?>'><?php echo $hr_list["pick_5"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_7"]; ?>'><?php echo $hr_list["pick_7"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_9"]; ?>'><?php echo $hr_list["pick_9"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Jungle:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_2" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_2" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_1"]; ?>'><?php echo $hr_list["pick_1"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_3"]; ?>'><?php echo $hr_list["pick_3"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_5"]; ?>'><?php echo $hr_list["pick_5"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_7"]; ?>'><?php echo $hr_list["pick_7"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_9"]; ?>'><?php echo $hr_list["pick_9"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p class="w-40 flex justify-center">Атака:</p>
                                                            <p class="w-40 flex justify-center">Защита:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="jungle_a_1" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control mr-6 bg-red-50" value="">
                                                                <option value=""></option>
                                                                <option value="1">Top</option>
                                                                <option value="3">Middle</option>
                                                                <option value="4">Carry</option>
                                                                <option value="5">Support</option>
                                                            </select>
                                                            <select type="text" name="jungle_d_1" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control bg-green-50" value="">
                                                                <option value=""></option>
                                                                <option value="1">Top</option>
                                                                <option value="3">Middle</option>
                                                                <option value="4">Carry</option>
                                                                <option value="5">Support</option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Middle:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_3" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_3" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_1"]; ?>'><?php echo $hr_list["pick_1"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_3"]; ?>'><?php echo $hr_list["pick_3"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_5"]; ?>'><?php echo $hr_list["pick_5"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_7"]; ?>'><?php echo $hr_list["pick_7"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_9"]; ?>'><?php echo $hr_list["pick_9"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Carry:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_4" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_4" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_1"]; ?>'><?php echo $hr_list["pick_1"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_3"]; ?>'><?php echo $hr_list["pick_3"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_5"]; ?>'><?php echo $hr_list["pick_5"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_7"]; ?>'><?php echo $hr_list["pick_7"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_9"]; ?>'><?php echo $hr_list["pick_9"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Support:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_5" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_5" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_1"]; ?>'><?php echo $hr_list["pick_1"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_3"]; ?>'><?php echo $hr_list["pick_3"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_5"]; ?>'><?php echo $hr_list["pick_5"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_7"]; ?>'><?php echo $hr_list["pick_7"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_9"]; ?>'><?php echo $hr_list["pick_9"]; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p>Капитан:</p>
                                                    </div>
                                                    <div id="fields-captain" class="flex flex-row justify-center items-center">
                                                        <select type="text" name="captain_1" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control kb-list" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_1 /*ORDER BY warehouse_id DESC*/");
                                                            while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                            ?>
                                                                <option hidden value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="flex flex-row w-full justify-center mt-6">
                                                        <button type="submit" class="inline-flex items-center w-48 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md justify-center">
                                                            Отправить
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($prmtch_info['user_2'] == $user_id) {
                                    ?>
                                        <div class="flex flex-row">
                                            <div class="flex flex-wrap w-1/3 justify-center items-center">
                                                <?php
                                                $heroes_list = mysqli_query($connect, "SELECT hero_name FROM `heroes`/*ORDER BY warehouse_id DESC*/");
                                                while ($hrs_list = mysqli_fetch_assoc($heroes_list)) {
                                                ?>
                                                    <img class="h-20 w-20 mx-2 m-2 rounded-lg drop-shadow-lg
                                                <?php
                                                    $hero_action = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                    $hr_pick_left = mysqli_fetch_assoc($hero_action);
                                                    if (($hrs_list["hero_name"] == $hr_pick_left['pick_1']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_3']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_5']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_7']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_9'])) {
                                                ?>
                                                border-8 border-rose-600
                                                <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['pick_2']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_4']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_6']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_8']) || ($hrs_list["hero_name"] == $hr_pick_left['pick_10'])) {
                                                ?>
                                                    border-8 border-indigo-600
                                                    <?php
                                                    } elseif (($hrs_list["hero_name"] == $hr_pick_left['ban_1']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_2']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_3']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_4']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_5']) || ($hrs_list["hero_name"] == $hr_pick_left['ban_6'])) {
                                                    ?>
                                                        blur-sm
                                                        <?php
                                                    }
                                                        ?>

                                                " src="/heroes/<?php echo $hrs_list["hero_name"]; ?>.png" alt="" title="<?php echo $hrs_list["hero_name"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="flex flex-col w-1/2 justify-center items-center">
                                                <div class="flex flex-row justify-around items-center w-40">
                                                    <?php
                                                    $user_position = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                    $usr_position = mysqli_fetch_assoc($user_position);
                                                    $user_1_information = $usr_position['user_1'];
                                                    $user_2_information = $usr_position['user_2'];

                                                    $user_1_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1_information'");
                                                    $usr_1_nickname = mysqli_fetch_assoc($user_1_nickname);

                                                    $user_2_nickname = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_2_information'");
                                                    $usr_2_nickname = mysqli_fetch_assoc($user_2_nickname);
                                                    ?>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-rose-600 font-bold"><?php echo $usr_1_nickname['user_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-gray-600 font-bold">vs</p>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p class="text-indigo-600 font-bold"><?php echo $usr_2_nickname['user_name']; ?></p>
                                                    </div>
                                                </div>
                                                <h1 class="font-bold flex flex-row justify-center">ПЛАНИРОВАНИЕ</h1>

                                                <?php
                                                if (isset($_SESSION['player_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['player_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['player_select_error']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['jungle_stats_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['jungle_stats_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['jungle_stats_select_error']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['hero_select_error_1'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['hero_select_error_1'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['hero_select_error_1']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['hero_select_error_2'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['hero_select_error_2'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['hero_select_error_2']);
                                                ?>

                                                <?php
                                                if (isset($_SESSION['captain_select_error'])) {
                                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                <div>
                                                                <span class="font-medium">' . $_SESSION['captain_select_error'] . '</span>
                                                                </div>
                                                            </div>';
                                                }
                                                unset($_SESSION['captain_select_error']);
                                                ?>

                                                <form action="/vendor/matches/prematch_stage_info_adding.php?game_id=<?php echo $game_id; ?>&phase=17" method="post" class="" enctype="multipart/form-data">
                                                    <div id="fields-list" class="div">
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Top:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_6" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <?php
                                                                $hero_pick = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'/*ORDER BY warehouse_id DESC*/");
                                                                $hro_pick = mysqli_fetch_assoc($hero_pick);
                                                                $user_2 = $hro_pick['user_2'];
                                                                ?>
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_6" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $hero_list = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
                                                                $hr_list = mysqli_fetch_assoc($hero_list)
                                                                ?>
                                                                <option value='<?php echo $hr_list["pick_2"]; ?>'><?php echo $hr_list["pick_2"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_4"]; ?>'><?php echo $hr_list["pick_4"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_6"]; ?>'><?php echo $hr_list["pick_6"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_8"]; ?>'><?php echo $hr_list["pick_8"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_10"]; ?>'><?php echo $hr_list["pick_10"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Jungle:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_7" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_7" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_2"]; ?>'><?php echo $hr_list["pick_2"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_4"]; ?>'><?php echo $hr_list["pick_4"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_6"]; ?>'><?php echo $hr_list["pick_6"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_8"]; ?>'><?php echo $hr_list["pick_8"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_10"]; ?>'><?php echo $hr_list["pick_10"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p class="w-40 flex justify-center">Атака:</p>
                                                            <p class="w-40 flex justify-center">Защита:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="jungle_a_2" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control mr-6 bg-red-50" value="">
                                                                <option value=""></option>
                                                                <option value="1">Top</option>
                                                                <option value="3">Middle</option>
                                                                <option value="4">Carry</option>
                                                                <option value="5">Support</option>
                                                            </select>
                                                            <select type="text" name="jungle_d_2" class="h-10 border rounded px-4 w-40 bg-grey-50 mt-1 form-control bg-green-50" value="">
                                                                <option value=""></option>
                                                                <option value="1">Top</option>
                                                                <option value="3">Middle</option>
                                                                <option value="4">Carry</option>
                                                                <option value="5">Support</option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Middle:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_8" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_8" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_2"]; ?>'><?php echo $hr_list["pick_2"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_4"]; ?>'><?php echo $hr_list["pick_4"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_6"]; ?>'><?php echo $hr_list["pick_6"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_8"]; ?>'><?php echo $hr_list["pick_8"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_10"]; ?>'><?php echo $hr_list["pick_10"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Carry:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_9" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_9" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_2"]; ?>'><?php echo $hr_list["pick_2"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_4"]; ?>'><?php echo $hr_list["pick_4"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_6"]; ?>'><?php echo $hr_list["pick_6"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_8"]; ?>'><?php echo $hr_list["pick_8"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_10"]; ?>'><?php echo $hr_list["pick_10"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <p>Support:</p>
                                                        </div>
                                                        <div class="flex flex-row justify-center items-center">
                                                            <select type="text" name="player_10" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list mr-6" value="">
                                                                <option value=""></option>
                                                                <?php
                                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                                ?>
                                                                    <option value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select type="text" name="hero_10" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control db-list" value="">
                                                                <option value=""></option>
                                                                <option value='<?php echo $hr_list["pick_2"]; ?>'><?php echo $hr_list["pick_2"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_4"]; ?>'><?php echo $hr_list["pick_4"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_6"]; ?>'><?php echo $hr_list["pick_6"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_8"]; ?>'><?php echo $hr_list["pick_8"]; ?></option>
                                                                <option value='<?php echo $hr_list["pick_10"]; ?>'><?php echo $hr_list["pick_10"]; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-row justify-center items-center">
                                                        <p>Капитан:</p>
                                                    </div>
                                                    <div id="fields-captain" class="flex flex-row justify-center items-center">
                                                        <select type="text" name="captain_2" class="h-10 border rounded px-4 w-64 bg-grey-50 mt-1 form-control kb-list" value="">
                                                            <option value=""></option>
                                                            <?php
                                                            $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = $user_2 /*ORDER BY warehouse_id DESC*/");
                                                            while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                            ?>
                                                                <option hidden value='<?php echo $plrs_list["player_id"]; ?>'><?php echo $plrs_list["player_f_name"]; ?> "<?php echo $plrs_list["player_nickname"]; ?>" <?php echo $plrs_list["player_l_name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="flex flex-row w-full justify-center mt-6">
                                                        <button type="submit" class="inline-flex items-center w-48 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md justify-center">
                                                            Отправить
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('.db-list').on('focus', function() {
            var ddl = $(this);
            ddl.data('previous', ddl.val());
        }).on('change', function() {
            var ddl = $(this);
            var previous = ddl.data('previous');
            ddl.data('previous', ddl.val());

            if (previous) {
                $('#fields-list').find('select option[value=' + previous + ']').removeAttr('hidden');
            }

            $('#fields-list').find('select option[value=' + $(this).val() + ']:not(:selected)').prop('hidden', true);
        });
    </script>

    <script>
        $('.bp-list').on('focus', function() {
            var ddl = $(this);
            ddl.data('previous', ddl.val());
        }).on('change', function() {
            var ddl = $(this);
            var previous = ddl.data('previous');
            ddl.data('previous', ddl.val());

            if (previous) {
                $('#ban-pick-list').find('select option[value=' + previous + ']').removeAttr('hidden');
            }

            $('#ban-pick-list').find('select option[value=' + $(this).val() + ']:not(:selected)').prop('hidden', true);
        });
    </script>


    <script>
        $('.db-list').on('focus', function() {
            var ddl = $(this);
            ddl.data('previous', ddl.val());
        }).on('change', function() {
            var ddl = $(this);
            var previous = ddl.data('previous');
            ddl.data('previous', ddl.val());

            if (previous) {
                $('#fields-captain').find('select option[value=' + previous + ']:not(:selected)').removeAttr('hidden');
            }
        });
    </script>





</body>

</html>