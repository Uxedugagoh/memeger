<?php
session_start();
require_once '../config/connect.php';
require_once '../vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: ../login.php');
}

$user_id = $_SESSION['user']['user_id'];

$friendly_games_count = mysqli_query($connect, "SELECT COUNT(game_id) as 'friendly_games_count' FROM `games` WHERE `user_1` = '$user_id' AND `phase` = 0");
$frndly_games_count = mysqli_fetch_assoc($friendly_games_count);
$frndly_gms_count = $frndly_games_count['friendly_games_count'];

$friendly_games_count_2 = mysqli_query($connect, "SELECT COUNT(game_id) as 'friendly_games_count_2' FROM `games` WHERE `user_1` = '$user_id' AND `phase` > 0 AND `phase` <= 17");
$frndly_games_count_2 = mysqli_fetch_assoc($friendly_games_count_2);
$frndly_gms_count_2 = $frndly_games_count_2['friendly_games_count_2'];

$friendly_games_count_3 = mysqli_query($connect, "SELECT COUNT(game_id) as 'friendly_games_count_3' FROM `games` WHERE `user_2` = '$user_id' AND `phase` > 0 AND `phase` <= 17");
$frndly_games_count_3 = mysqli_fetch_assoc($friendly_games_count_3);
$frndly_gms_count_3 = $frndly_games_count_3['friendly_games_count_3'];

if ($frndly_gms_count > 0) {
    $page_update_check = mysqli_query($connect, "SELECT * FROM `games` WHERE `user_1` = '$user_id' AND `phase` = 0");
    $pg_update_check = mysqli_fetch_assoc($page_update_check);
    $game_id_check = $pg_update_check['game_id'];
    $phase_check = $pg_update_check['phase'];
        if ($phase_check == 0) {
            $url = 'friendly_game.php';
            $sec = "5";
            header("Refresh: $sec; url=$url");
        } else {
            header('Location: prematch_stage.php?game_id=' . $game_id_check . '&phase=' . $phase_check);
        }
}

if ($frndly_gms_count_2 > 0) {
    $page_update_check = mysqli_query($connect, "SELECT * FROM `games` WHERE `user_1` = '$user_id' AND `phase` > 0 AND `phase` <= 17");
    $pg_update_check = mysqli_fetch_assoc($page_update_check);
    $game_id_check = $pg_update_check['game_id'];
    $phase_check = $pg_update_check['phase'];
            header('Location: prematch_stage.php?game_id=' . $game_id_check . '&phase=' . $phase_check);
}

if ($frndly_gms_count_3 > 0) {
    $page_update_check = mysqli_query($connect, "SELECT * FROM `games` WHERE `user_2` = '$user_id' AND `phase` > 0 AND `phase` <= 17");
    $pg_update_check = mysqli_fetch_assoc($page_update_check);
    $game_id_check = $pg_update_check['game_id'];
    $phase_check = $pg_update_check['phase'];
            header('Location: prematch_stage.php?game_id=' . $game_id_check . '&phase=' . $phase_check);
}



$game_waiting_count = mysqli_query($connect, "SELECT COUNT(game_id) as 'game_waiting_count' FROM `games` WHERE `user_1` > 0 AND `user_2` < 1");
$game_wtng_count = mysqli_fetch_assoc($game_waiting_count);
$gm_wtng_count = $game_wtng_count['game_waiting_count'];

if (isset($_GET['create_friendly_game'])) {
    $create_friendly_game = (intval($_GET['create_friendly_game']));
    if ($create_friendly_game == $user_id) {
        mysqli_query($connect, "INSERT INTO `games` (`game_id`, `game_type`, `user_1`, `phase`) VALUES (NULL, 1, '$user_id', 0)");
    }

    header('Location: friendly_game.php');
}

if (isset($_GET['cancel_friendly_game'])) {
    $cancel_friendly_game = (intval($_GET['cancel_friendly_game']));
    if ($cancel_friendly_game == $user_id) {
        mysqli_query($connect, "DELETE FROM `games` WHERE `user_1` = '$user_id' AND `phase` = 0 AND `game_type` = 1");
    }
    header('Location: friendly_game.php');
}

if (isset($_GET['accept_friendly_game'])) {
    $accept_friendly_game = (intval($_GET['accept_friendly_game']));
    $game_id = (intval($_GET['game_id']));
    if ($accept_friendly_game == $user_id) {
        mysqli_query($connect, "UPDATE `games` SET `user_2` = '$user_id', `phase` = 1 WHERE `game_id` = '$game_id'");
    }
    header('Location: prematch_stage.php?game_id=' . $game_id . '&phase=' . 1);
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
                                    <div class="flex flex-row justify-between">
                                        <h1 class="text-xl text-slate-700 font-medium">Товарищеские матчи</h1>
<?php
                                        if ($frndly_gms_count < 1) {
                                        ?>
                                        <a class="text-gray-400 hover:text-gray-600 flex flex-end" href="friendly_game.php?create_friendly_game=<?php echo $user_id; ?>">
                                            <button class="inline-flex items-center w-36 px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white text-sm font-medium rounded-md justify-center">
                                                Подать заявку
                                            </button>
                                        </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($gm_wtng_count < 1) {
                                    ?>
                                        <div class="flex flex-col w-full items-end">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-14">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                                            </svg>
                                            <p class="mr-4">Подать заявку</p>
                                        </div>
                                        <div class="flex flex-col w-full h-80 justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p>Активных заявок нет <?php echo $gm_wtng_count ?></p>
                                        </div>
                                    <?php
                                    } else {
                                    ?>

                                        <table class="border-collapse border border-slate-400 w-full mt-5">
                                            <thead>
                                                <tr>
                                                    <th class="border border-slate-300 w-80 bg-gray-200">Команда</th>
                                                    <th class="border border-slate-300 px-2 bg-gray-200">Уровень</th>
                                                    <th class="border border-slate-300 px-2 bg-gray-200" title="Средний возраст">Ср. Воз</th>
                                                    <th class="border border-slate-300 px-2 bg-gray-200" title="Средний талант">Ср. Тал</th>
                                                    <th class="border border-slate-300 px-2 bg-gray-200" title="Среднее мастерство">Ср. Мас</th>
                                                    <th class="border border-slate-300 px-2 bg-gray-200" title="Количество подписчиков">Под</th>
                                                    <th class="border border-slate-300" title=""></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $game_waiting_list = mysqli_query($connect, "SELECT * FROM `games` WHERE `user_1` > 0 AND `user_2` < 1");
                                                while ($game_wtng_list = mysqli_fetch_assoc($game_waiting_list)) {
                                                    $user_1 = $game_wtng_list['user_1'];

                                                    $team_name_request = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_1'");
                                                    $tm_name_request = mysqli_fetch_assoc($team_name_request);


                                                    /*---------------------------------------------Средний возраст игроков---------------------------------------------*/
                                                    $team_age_sum = mysqli_query($connect, "SELECT SUM(player_age) as team_age_sum FROM `players` WHERE `user_id` = '$user_1'");
                                                    $tm_age_sum = mysqli_fetch_assoc($team_age_sum);
                                                    $tm_age_sm = $tm_age_sum['team_age_sum'];

                                                    $team_age_count = mysqli_query($connect, "SELECT COUNT(player_id) as 'team_age_count' FROM `players` WHERE `user_id` = '$user_1'");
                                                    $tm_age_count = mysqli_fetch_assoc($team_age_count);
                                                    $tm_age_cnt = $tm_age_count['team_age_count'];

                                                    $avg_team_age = $tm_age_sm / $tm_age_cnt;
                                                    $avg_team_age = number_format($avg_team_age, 1, ',', ' ');
                                                    /*---------------------------------------------------------------------------------------------------------------*/


                                                    /*---------------------------------------------Средний талант игроков---------------------------------------------*/
                                                    $team_tal_sum = mysqli_query($connect, "SELECT SUM(player_talent) as team_tal_sum FROM `players` WHERE `user_id` = '$user_1'");
                                                    $tm_tal_sum = mysqli_fetch_assoc($team_tal_sum);
                                                    $tm_tal_sm = $tm_tal_sum['team_tal_sum'];

                                                    $avg_team_tal = $tm_tal_sm / $tm_age_cnt;
                                                    $avg_team_tal = number_format($avg_team_tal, 1, ',', ' ');
                                                    /*---------------------------------------------------------------------------------------------------------------*/

                                                    /*---------------------------------------------Среднее мастерство игроков---------------------------------------------*/
                                                    $team_mas_sum = mysqli_query($connect, "SELECT SUM(player_stamina + player_reaction + player_position_selection + player_map_vision + player_mechanic_knowledge + player_last_hit + player_composure + player_intuition + player_communication + player_leadership + player_discipline + player_toxic_resistance) as team_mas_sum FROM `players` WHERE `user_id` = '$user_1'");
                                                    $tm_mas_sum = mysqli_fetch_assoc($team_mas_sum);
                                                    $tm_mas_sm = $tm_mas_sum['team_mas_sum'];

                                                    $avg_team_mas = ($tm_mas_sm / $tm_age_cnt) / 12;
                                                    $avg_team_mas = number_format($avg_team_mas, 2, ',', ' ');
                                                    /*---------------------------------------------------------------------------------------------------------------*/
                                                ?>
                                                    <tr>
                                                        <td class="border border-slate-300 pl-1 underline">
                                                            <a href="../team.php?id=<?php echo $tm_name_request["user_id"]; ?>">
                                                                <?php echo $tm_name_request["user_name"]; ?>
                                                            </a>
                                                        </td>
                                                        <td align="center" class="border border-slate-300">Позже</td>
                                                        <td align="center" class="border border-slate-300"><?php echo $avg_team_age; ?></td>


                                                        <td align="center" class="border border-slate-300"><?php echo $avg_team_tal; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $avg_team_mas; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $tm_name_request['user_fans']; ?></td>

                                                        <td align="center" class="border border-slate-300">
                                                            <?php
                                                            if ($user_1 == $user_id) {
                                                            ?>
                                                                <a class="text-gray-400 hover:text-gray-600 flex justify-center" href="friendly_game.php?cancel_friendly_game=<?php echo $user_id; ?>">
                                                                    <button class="inline-flex items-center w-36 px-4 py-2 my-3 bg-red-400 hover:bg-red-500 text-white text-sm font-medium rounded-md justify-center">
                                                                        Отменить
                                                                    </button>
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>

                                                                <a class="text-gray-400 hover:text-gray-600 flex justify-center" href="friendly_game.php?game_id=<?php echo $game_wtng_list['game_id']; ?>&accept_friendly_game=<?php echo $user_id; ?>">
                                                                    <button class="inline-flex items-center w-36 px-4 py-2 my-3 bg-green-400 hover:bg-green-500 text-white text-sm font-medium rounded-md justify-center">
                                                                        Вызвать
                                                                    </button>
                                                                <?php
                                                            }
                                                                ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
    </div>
</body>

</html>