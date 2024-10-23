<?php

session_start();
    require_once '../../config/connect.php';

    if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
    }

/*-----------------------------------------------------------------*/
// Проверить, отправляет ли игрок игроков/героев/капитана;
/*-----------------------------------------------------------------*/

$user_id = $_SESSION['user']['user_id'];
$game_id = (intval($_GET['game_id']));
$phase = (intval($_GET['phase']));

date_default_timezone_set('Asia/Yekaterinburg');
$team_sent_time = date("Y.m.d H:i:s"); 


$letters = '/^[a-zA-Z0-9]+$/u';
$numbers = '/^[0-9]+$/u';

$game_info = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
$gm_info = mysqli_fetch_assoc($game_info);

$actual_phase = $gm_info['phase'];

if (($phase == $gm_info['phase']) && ($gm_info['phase'] == 1) && ($user_id == $gm_info['user_1'])) {
    $ban_1 = filter_var(trim($_POST['ban_1']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_1)) {
        $_SESSION['ban_1_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=1');
    }
    if (!$_SESSION['ban_1_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_1` = '$ban_1', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_1_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=2');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 2) && ($user_id == $gm_info['user_2'])) {
    $ban_2 = filter_var(trim($_POST['ban_2']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_2)) {
        $_SESSION['ban_2_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=2');
    }
    if (!$_SESSION['ban_2_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_2` = '$ban_2', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_2_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=3');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 3) && ($user_id == $gm_info['user_1'])) {
    $ban_3 = filter_var(trim($_POST['ban_3']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_3)) {
        $_SESSION['ban_3_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=3');
    }
    if (!$_SESSION['ban_3_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_3` = '$ban_3', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_3_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=4');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 4) && ($user_id == $gm_info['user_2'])) {
    $ban_4 = filter_var(trim($_POST['ban_4']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_4)) {
        $_SESSION['ban_4_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=4');
    }
    if (!$_SESSION['ban_4_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_4` = '$ban_4', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_4_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=5');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 5) && ($user_id == $gm_info['user_1'])) {
    $ban_5 = filter_var(trim($_POST['ban_5']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_5)) {
        $_SESSION['ban_5_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=5');
    }
    if (!$_SESSION['ban_5_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_5` = '$ban_5', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_5_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=6');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 6) && ($user_id == $gm_info['user_2'])) {
    $ban_6 = filter_var(trim($_POST['ban_6']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $ban_6)) {
        $_SESSION['ban_6_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=6');
    }
    if (!$_SESSION['ban_6_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `ban_6` = '$ban_6', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['ban_6_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=7');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 7) && ($user_id == $gm_info['user_1'])) {
    $pick_1 = filter_var(trim($_POST['pick_1']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_1)) {
        $_SESSION['pick_1_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=7');
    }
    if (!$_SESSION['pick_1_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_1` = '$pick_1', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_1_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=8');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 8) && ($user_id == $gm_info['user_2'])) {
    $pick_2 = filter_var(trim($_POST['pick_2']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_2)) {
        $_SESSION['pick_2_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=8');
    }
    if (!$_SESSION['pick_2_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_2` = '$pick_2', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_2_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=9');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 9) && ($user_id == $gm_info['user_1'])) {
    $pick_3 = filter_var(trim($_POST['pick_3']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_3)) {
        $_SESSION['pick_3_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=9');
    }
    if (!$_SESSION['pick_3_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_3` = '$pick_3', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_3_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=10');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 10) && ($user_id == $gm_info['user_2'])) {
    $pick_4 = filter_var(trim($_POST['pick_4']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_4)) {
        $_SESSION['pick_4_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=10');
    }
    if (!$_SESSION['pick_4_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_4` = '$pick_4', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_4_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=11');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 11) && ($user_id == $gm_info['user_1'])) {
    $pick_5 = filter_var(trim($_POST['pick_5']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_5)) {
        $_SESSION['pick_5_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=11');
    }
    if (!$_SESSION['pick_5_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_5` = '$pick_5', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_5_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=12');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 12) && ($user_id == $gm_info['user_2'])) {
    $pick_6 = filter_var(trim($_POST['pick_6']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_6)) {
        $_SESSION['pick_6_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=12');
    }
    if (!$_SESSION['pick_6_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_6` = '$pick_6', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_6_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=13');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 13) && ($user_id == $gm_info['user_1'])) {
    $pick_7 = filter_var(trim($_POST['pick_7']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_7)) {
        $_SESSION['pick_7_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=13');
    }
    if (!$_SESSION['pick_7_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_7` = '$pick_7', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_7_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=14');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 14) && ($user_id == $gm_info['user_2'])) {
    $pick_8 = filter_var(trim($_POST['pick_8']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_8)) {
        $_SESSION['pick_8_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=14');
    }
    if (!$_SESSION['pick_8_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_8` = '$pick_8', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_8_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=15');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 15) && ($user_id == $gm_info['user_1'])) {
    $pick_9 = filter_var(trim($_POST['pick_9']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_9)) {
        $_SESSION['pick_9_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=15');
    }
    if (!$_SESSION['pick_9_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_9` = '$pick_9', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_9_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=16');
} 
} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 16) && ($user_id == $gm_info['user_2'])) {
    $pick_10 = filter_var(trim($_POST['pick_10']), FILTER_UNSAFE_RAW);
    if (!preg_match($letters, $pick_10)) {
        $_SESSION['pick_10_error'] = 'Недопустимые символы';
        header('Location: /matches/prematch_stage.php?game_id=' .$game_id. '&phase=16');
    }
    if (!$_SESSION['pick_10_error']) {
        $next_phase = $phase + 1;
    mysqli_query($connect, "UPDATE `games` SET `pick_10` = '$pick_10', `phase` = '$next_phase' WHERE `game_id` = $game_id");

    $_SESSION['pick_10_accepted'] = 'Герой забанен!';
    header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
} 

/*-----------------------------------------------------------------*/
// Проверка на отправку состава первым игроком;
// ---------УЧАСТНИК ВСЕ ЕЩЕ МОЖЕТ ОТПРАВИТЬ НЕ СВОИХ ИГРОКОВ, КАПИТАНА И ГЕРОЕВ НА МАТЧ (НУЖНА ЕЩЕ ПРОВЕРКА)
/*-----------------------------------------------------------------*/

} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 17) && ($user_id == $gm_info['user_1'])) {
    $player_1 = (intval($_POST['player_1']));
    if($player_1 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_2 = (intval($_POST['player_2']));
    if($player_2 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_3 = (intval($_POST['player_3']));
    if($player_3 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_4 = (intval($_POST['player_4']));
    if($player_4 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_5 = (intval($_POST['player_5']));
    if($player_5 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_1 = filter_var(trim($_POST['hero_1']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_1) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_1)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_2 = filter_var(trim($_POST['hero_2']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_2) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_2)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_3 = filter_var(trim($_POST['hero_3']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_3) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_3)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_4 = filter_var(trim($_POST['hero_4']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_4) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_4)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_5 = filter_var(trim($_POST['hero_5']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_5) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_5)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $captain_1 = (intval($_POST['captain_1']));
    if($captain_1 < 1) {
        $_SESSION['captain_select_error'] = 'Выберите капитана!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $jungle_a_1 = (intval($_POST['jungle_a_1']));
    if($jungle_a_1 < 1) {
        $_SESSION['jungle_stats_select_error'] = 'Выберите поддерживаемую лесником линию!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $jungle_d_1 = (intval($_POST['jungle_d_1']));
    if($jungle_d_1 < 1) {
        $_SESSION['jungle_stats_select_error'] = 'Выберите поддерживаемую лесником линию!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $players_hero_points_1 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_1' AND `hero` = '$hero_1'");
    $plrs_hero_points_1 = mysqli_fetch_assoc($players_hero_points_1);
    if ($plrs_hero_points_1['points'] >= 100) {
        $player_hero_1 = 1;
    } else {
        $player_hero_1 = 0;
    }
    
    $players_hero_points_2 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_2' AND `hero` = '$hero_2'");
    $plrs_hero_points_2 = mysqli_fetch_assoc($players_hero_points_2);
    if ($plrs_hero_points_2['points'] >= 100) {
        $player_hero_2 = 1;
    } else {
        $player_hero_2 = 0;
    }

    $players_hero_points_3 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_3' AND `hero` = '$hero_3'");
    $plrs_hero_points_3 = mysqli_fetch_assoc($players_hero_points_3);
    if ($plrs_hero_points_3['points'] >= 100) {
        $player_hero_3 = 1;
    } else {
        $player_hero_3 = 0;
    }

    $players_hero_points_4 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_4' AND `hero` = '$hero_4'");
    $plrs_hero_points_4 = mysqli_fetch_assoc($players_hero_points_4);
    if ($plrs_hero_points_4['points'] >= 100) {
        $player_hero_4 = 1;
    } else {
        $player_hero_4 = 0;
    }

    $players_hero_points_5 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_5' AND `hero` = '$hero_5'");
    $plrs_hero_points_5 = mysqli_fetch_assoc($players_hero_points_5);
    if ($plrs_hero_points_5['points'] >= 100) {
        $player_hero_5 = 1;
    } else {
        $player_hero_5 = 0;
    }

    if (!$_SESSION['player_select_error'] && !$_SESSION['hero_select_error_1'] && !$_SESSION['hero_select_error_2'] && !$_SESSION['captain_select_error'] && !$_SESSION['jungle_stats_select_error']) {
    mysqli_query($connect, "UPDATE `games` SET `player_1` = '$player_1', `player_2` = '$player_2', `player_3` = '$player_3', `player_4` = '$player_4', `player_5` = '$player_5', `hero_1` = '$hero_1', `hero_2` = '$hero_2', `hero_3` = '$hero_3', `hero_4` = '$hero_4', `hero_5` = '$hero_5', `player_hero_1` = '$player_hero_1', `player_hero_2` = '$player_hero_2', `player_hero_3` = '$player_hero_3', `player_hero_4` = '$player_hero_4', `player_hero_5` = '$player_hero_5', `captain_1` = '$captain_1', `team_1_sent_time` = '$team_sent_time' , `jungle_a_1` = '$jungle_a_1', `jungle_d_1` = '$jungle_d_1' WHERE `game_id` = $game_id");

    $_SESSION['players_team_1_saved'] = 'Состав отправлен!';
    header('Location: ../../matches/game_waiting.php?game_id=' .$game_id);
    }

/*-----------------------------------------------------------------*/
// Проверка на отправку состава вторым игроком;
// ---------УЧАСТНИК ВСЕ ЕЩЕ МОЖЕТ ОТПРАВИТЬ НЕ СВОИХ ИГРОКОВ, КАПИТАНА И ГЕРОЕВ НА МАТЧ (НУЖНА ЕЩЕ ПРОВЕРКА)
/*-----------------------------------------------------------------*/

} elseif (($phase == $gm_info['phase']) && ($gm_info['phase'] == 17) && ($user_id == $gm_info['user_2'])) {
    $player_6 = (intval($_POST['player_6']));
    if($player_6 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_7 = (intval($_POST['player_7']));
    if($player_7 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_8 = (intval($_POST['player_8']));
    if($player_8 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_9 = (intval($_POST['player_9']));
    if($player_9 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }
    $player_10 = (intval($_POST['player_10']));
    if($player_10 < 1) {
        $_SESSION['player_select_error'] = 'Выберите всех игроков!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_6 = filter_var(trim($_POST['hero_6']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_6) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_6)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_7 = filter_var(trim($_POST['hero_7']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_7) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_7)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_8 = filter_var(trim($_POST['hero_8']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_8) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_8)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_9 = filter_var(trim($_POST['hero_9']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_9) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_9)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $hero_10 = filter_var(trim($_POST['hero_10']), FILTER_UNSAFE_RAW);
    if(mb_strlen($hero_10) < 1) {
        $_SESSION['hero_select_error_1'] = 'Выберите всех героев!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    } elseif (!preg_match($letters, $hero_10)) {
        $_SESSION['hero_select_error_2'] = 'Недопустимые символы';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $captain_2 = (intval($_POST['captain_2']));
    if($captain_2 < 1) {
        $_SESSION['captain_select_error'] = 'Выберите капитана!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $jungle_a_2 = (intval($_POST['jungle_a_2']));
    if($jungle_a_2 < 1) {
        $_SESSION['jungle_stats_select_error'] = 'Выберите поддерживаемую лесником линию!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $jungle_d_2 = (intval($_POST['jungle_d_2']));
    if($jungle_d_2 < 1) {
        $_SESSION['jungle_stats_select_error'] = 'Выберите поддерживаемую лесником линию!';
        header('Location: ../../matches/prematch_stage.php?game_id=' .$game_id. '&phase=17');
    }

    $players_hero_points_6 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_6' AND `hero` = '$hero_6'");
    $plrs_hero_points_6 = mysqli_fetch_assoc($players_hero_points_6);
    if ($plrs_hero_points_6['points'] >= 100) {
        $player_hero_6 = 1;
    } else {
        $player_hero_6 = 0;
    }

    $players_hero_points_7 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_7' AND `hero` = '$hero_7'");
    $plrs_hero_points_7 = mysqli_fetch_assoc($players_hero_points_7);
    if ($plrs_hero_points_7['points'] >= 100) {
        $player_hero_7 = 1;
    } else {
        $player_hero_7 = 0;
    }

    $players_hero_points_8 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_8' AND `hero` = '$hero_8'");
    $plrs_hero_points_8 = mysqli_fetch_assoc($players_hero_points_8);
    if ($plrs_hero_points_8['points'] >= 100) {
        $player_hero_8 = 1;
    } else {
        $player_hero_8 = 0;
    }

    $players_hero_points_9 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_9' AND `hero` = '$hero_9'");
    $plrs_hero_points_9 = mysqli_fetch_assoc($players_hero_points_9);
    if ($plrs_hero_points_9['points'] >= 100) {
        $player_hero_9 = 1;
    } else {
        $player_hero_9 = 0;
    }

    $players_hero_points_10 = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_10' AND `hero` = '$hero_10'");
    $plrs_hero_points_10 = mysqli_fetch_assoc($players_hero_points_10);
    if ($plrs_hero_points_10['points'] >= 100) {
        $player_hero_10 = 1;
    } else {
        $player_hero_10 = 0;
    }

    if (!$_SESSION['player_select_error'] && !$_SESSION['hero_select_error_1'] && !$_SESSION['hero_select_error_2'] && !$_SESSION['captain_select_error'] && !$_SESSION['jungle_stats_select_error']) {
    mysqli_query($connect, "UPDATE `games` SET `player_6` = '$player_6', `player_7` = '$player_7', `player_8` = '$player_8', `player_9` = '$player_9', `player_10` = '$player_10', `hero_6` = '$hero_6', `hero_7` = '$hero_7', `hero_8` = '$hero_8', `hero_9` = '$hero_9', `hero_10` = '$hero_10', `player_hero_6` = '$player_hero_6', `player_hero_7` = '$player_hero_7', `player_hero_8` = '$player_hero_8', `player_hero_9` = '$player_hero_9', `player_hero_10` = '$player_hero_10', `captain_2` = '$captain_2', `team_2_sent_time` = '$team_sent_time', `jungle_a_2` = '$jungle_a_2', `jungle_d_2` = '$jungle_d_2' WHERE `game_id` = $game_id");

    $_SESSION['players_team_2_saved'] = 'Состав отправлен!';
    header('Location: ../../matches/game_waiting.php?game_id=' .$game_id);
    }
}
