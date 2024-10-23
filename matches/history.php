<?php
session_start();
require_once '../config/connect.php';
require_once '../vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

$team_id = (intval($_GET['team_id']));
$team_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$team_id'");
$tm_name = mysqli_fetch_assoc($team_name);





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

                                    <div class="flex flex-row items-center mb-3">
                                        <h1 class="text-xl text-slate-700 font-medium mr-2">История игр команды</h1>
                                        <a class="underline" href="/team.php?id=<?php echo $team_id; ?>">
                                            <?php echo $tm_name['user_name']; ?>
                                        </a>
                                    </div>
                                    <div class="flex flex-col">
                                        <?php
                                        $game_info = mysqli_query($connect, "SELECT * FROM `games` WHERE `user_1` = '$team_id' AND `phase` = '18' OR `user_2` = '$team_id' AND `phase` = '18'");
                                        while ($gm_info = mysqli_fetch_assoc($game_info)) {
                                        ?>
                                            <div class="flex flex-row justify-center my-2">
                                                <div class="flex flex-row">
                                                    <?php
                                                    if ($gm_info['team_1_sent_time'] > $gm_info['team_2_sent_time']) {
                                                        echo $gm_info['team_1_sent_time'];
                                                    } else {
                                                        echo $gm_info['team_2_sent_time'];
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex flex-row mx-6">
                                                    <?php
                                                    if ($gm_info['game_type'] = 1) {
                                                        echo 'Товарищеская игра';
                                                    } else {
                                                        echo 'Другая игра';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex flex-row mx-6">
                                                    <a class="underline" href="/team.php?id=<?php echo $gm_info['user_1']; ?>">
                                                        <div class="flex flex-row mr-2"><?php
                                                                                        $team_1_id = $gm_info['user_1'];
                                                                                        $team_1_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$team_1_id'");
                                                                                        $tm_1_name = mysqli_fetch_assoc($team_1_name);
                                                                                        echo $tm_1_name['user_name']; ?>
                                                        </div>
                                                    </a>
                                                    <div class="flex flex-row">
                                                        <?php
                                                        $game_id = $gm_info['game_id'];
                                                        $game_score = mysqli_query($connect, "SELECT * FROM `game_report` WHERE `game_id` = '$game_id'");
                                                        $gm_score = mysqli_fetch_assoc($game_score);
                                                        ?>
                                                        <div class="flex flex-row"><?php echo $gm_score['team_1_final_score']; ?></div>
                                                        :
                                                        <div class="flex flex-row"><?php echo $gm_score['team_2_final_score']; ?></div>
                                                    </div>
                                                    <a class="underline" href="/team.php?id=<?php echo $gm_info['user_2']; ?>">
                                                        <div class="flex flex-row ml-2"><?php
                                                                                        $team_2_id = $gm_info['user_2'];
                                                                                        $team_2_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$team_2_id'");
                                                                                        $tm_2_name = mysqli_fetch_assoc($team_2_name);
                                                                                        echo $tm_2_name['user_name']; ?>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="flex flex-row mx-6">
                                                <a class="underline" href="/matches/game_report.php?game_id=<?php echo $gm_info['game_id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                </a>
                                                </div>
                                            </div>
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
    </div>
</body>

</html>