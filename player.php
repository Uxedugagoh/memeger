<?php
session_start();
require_once 'config/connect.php';
require_once 'vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: login.php');
}

$user_id = $_SESSION['user']['user_id'];
$player_id = (intval($_GET['id']));

$player_details = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = '$player_id' /*ORDER BY warehouse_id DESC*/");
$plr_details = mysqli_fetch_assoc($player_details);


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
    <link rel="icon" href="/img/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Профиль игрока</title>
</head>

<body>
    <div class="flex flex-nowrap bg-gray-100 min-w-max min-h-screen">
        <div class="w-1/6 bg-white rounded p-3 shadow-lg max-w-xs min-w-fit">
            <?php include "includes/sidebar.php"; ?>
        </div>





        <div class="w-5/6">
            <div class="p-4 text-gray-500">
                <div class="max-w-screen-2xl mx-auto">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="p-4 flex flex-row justify-between content-center border-t">
                            <?php include "includes/topmenu.php"; ?>

                        </div>
                        <div class="p-4 flex flex-col justify-between content-center border-t">
                            <div class="flex flex-row w-full justify-around">
                                <div class="w-full bg-white/60 hover:bg-white/80 hover:shadow-lg transition duration-150 ease-linear backdrop-blur-xl right-5 top-36 rounded-lg p-6 shadow">
                                    <h1 class="text-xl text-slate-700 font-medium">Информация об игроке</h1>
                                    <div class="flex flex-row mb-6 underline">
                                        <a href="/player.php?id=<?php echo $plr_details["player_id"]; ?>">
                                            <?php echo $plr_details["player_f_name"]; ?>
                                            "<b><?php echo $plr_details["player_nickname"]; ?></b>"
                                            <?php echo $plr_details["player_l_name"]; ?>
                                        </a>
                                        <?php
                                        $player_nat = $plr_details["player_nationality"];
                                        $nat_name = ${"f_name_$player_nat"}[mt_rand(0, 0)];

                                        echo '<img class="h-5 w-8 mx-2 rounded-full drop-shadow-lg" title="' . $nat_name . '" src="img/' . $player_nat . '.jpg " alt="' . $player_nat . '"/>';
                                        ?>
                                        <b class="mr-1"><?php echo $plr_details["player_position"]; ?></b>
                                        <b><?php echo $plr_details["player_age"]; ?></b>
                                        <b><?php echo '/' ?></b>

                                        <?php
                                        $player_stamina = $plr_details["player_stamina"];
                                        $player_reaction = $plr_details["player_reaction"];
                                        $player_position_selection = $plr_details["player_position_selection"];
                                        $player_map_vision = $plr_details["player_map_vision"];
                                        $player_mechanic_knowledge = $plr_details["player_mechanic_knowledge"];
                                        $player_last_hit = $plr_details["player_last_hit"];
                                        $player_composure = $plr_details["player_composure"];
                                        $player_intuition = $plr_details["player_intuition"];
                                        $player_communication = $plr_details["player_communication"];
                                        $player_leadership = $plr_details["player_leadership"];
                                        $player_discipline = $plr_details["player_discipline"];
                                        $player_toxic_resistance = $plr_details["player_toxic_resistance"];
                                        $player_mastery = (($player_stamina + $player_reaction + $player_position_selection + $player_map_vision + $player_mechanic_knowledge + $player_last_hit + $player_composure + $player_intuition + $player_communication + $player_leadership + $player_discipline + $player_toxic_resistance) / 12);
                                        $player_mastery = number_format($player_mastery, 0, ',', ' ');
                                        ?>
                                        <b class="mr-1"><?php echo $player_mastery; ?></b>
                                        <a class="" href="/team.php?id=<?php echo $plr_details["user_id"]; ?>">
                                            (
                                            <a class="underline" href="/team.php?id=<?php echo $plr_details["user_id"]; ?>">
                                                <?php echo $plr_details["user_id"]; ?>
                                            </a>
                                            )
                                    </div>

                                    <div class="flex flex-row justify-between mb-6">
                                        <div class="flex flex-col mr-8">
                                            <h1 class="text-xl text-slate-700 font-medium mb-1">Умения игрока</h1>
                                            <div class="flex flex-row mb-3">
                                                <table class="border-collapse border border-slate-400 ...">
                                                    <thead>
                                                        <tr>
                                                            <th class="border border-slate-300 underline bg-slate-100">Мастертсво</th>
                                                            <td align="center" class="border border-slate-300 bg-slate-100"><?php echo $player_mastery; ?></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-60 bg-lime-100">Выносливость</th>
                                                            <td align="center" class="border border-slate-300 w-20"><?php echo $player_stamina; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Реакция</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_reaction; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Выбор позиции</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_position_selection; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Видение карты</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_map_vision; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Знание механик</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_mechanic_knowledge; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Добивание</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_last_hit; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Самообладание</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_composure; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Интуиция</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_intuition; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Коммуникация</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_communication; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Лидерство</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_leadership; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Дисциплина</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_discipline; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Токсик резистентность</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $player_toxic_resistance; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="flex flex-col mr-8">
                                            <h1 class="text-xl text-slate-700 font-medium mb-1">Характеристики</h1>
                                            <div class="flex flex-row mb-3">
                                                <table class="border-collapse border border-slate-400 ...">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 ">Возраст</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $plr_details["player_age"]; ?></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-60">Национальность</th>
                                                            <td align="center" class="border border-slate-300 w-20">
                                                                <?php
                                                                $player_nat = $plr_details["player_nationality"];
                                                                $nat_name = ${"f_name_$player_nat"}[mt_rand(0, 0)];
                                                                echo $nat_name;
                                                                ?>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40">Позиция</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $plr_details["player_position"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40">Талант</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $plr_details["player_talent"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-lime-100">Физготовность</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $plr_details["player_physical"]; ?>%</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40 bg-yellow-100">Мораль</th>
                                                            <td align="center" class="border border-slate-300"><?php echo $plr_details["player_morality"]; ?>%</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40">Стоимость</th>

                                                            <?php
                                                            $stamina_level = $plr_details["player_stamina"];
                                                            $reaction_level = $plr_details["player_reaction"];
                                                            $position_selection_level = $plr_details["player_position_selection"];
                                                            $map_vision_level = $plr_details["player_map_vision"];
                                                            $mechanic_knowledge_level = $plr_details["player_mechanic_knowledge"];
                                                            $last_hit_level = $plr_details["player_last_hit"];
                                                            $composure_level = $plr_details["player_composure"];
                                                            $intuition_level = $plr_details["player_intuition"];
                                                            $communication_level = $plr_details["player_communication"];
                                                            $leadership_level = $plr_details["player_leadership"];
                                                            $discipline_level = $plr_details["player_discipline"];
                                                            $toxic_resistance_level = $plr_details["player_toxic_resistance"];

                                                            $experience_spent_stamina = $training_array_straight[$stamina_level];
                                                            $experience_spent_reaction = $training_array_straight[$reaction_level];
                                                            $experience_spent_position_selection = $training_array_straight[$position_selection_level];
                                                            $experience_spent_map_vision = $training_array_straight[$map_vision_level];
                                                            $experience_spent_mechanic_knowledge = $training_array_straight[$mechanic_knowledge_level];
                                                            $experience_spent_last_hit = $training_array_straight[$last_hit_level];
                                                            $experience_spent_composure = $training_array_straight[$composure_level];
                                                            $experience_spent_intuition = $training_array_straight[$intuition_level];
                                                            $experience_spent_communication = $training_array_straight[$communication_level];
                                                            $experience_spent_leadership = $training_array_straight[$leadership_level];
                                                            $experience_spent_discipline = $training_array_straight[$discipline_level];
                                                            $experience_spent_toxic_resistance = $training_array_straight[$toxic_resistance_level];

                                                            $total_experience_spent = (($experience_spent_stamina + $experience_spent_reaction + $experience_spent_position_selection + $experience_spent_map_vision + $experience_spent_mechanic_knowledge + $experience_spent_last_hit + $experience_spent_composure + $experience_spent_intuition + $experience_spent_communication + $experience_spent_leadership + $experience_spent_discipline + $experience_spent_toxic_resistance) * (($plr_details["player_talent"] / 10) + 1));
                                                            ?>


                                                            <td align="center" class="border border-slate-300"><?php echo number_format($total_experience_spent, 0, ',', ' '); ?></td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                        <div class="flex flex-col">
                                            <h1 class="text-xl text-slate-700 font-medium mb-1">Статистика</h1>
                                            <div class="flex flex-row mb-3">
                                                <table class="border-collapse border border-slate-400 ...">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 ">Игры</th>
                                                            <td align="center" class="border border-slate-300"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-60">Победы</th>
                                                            <td align="center" class="border border-slate-300 w-20"></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th align="left" class="border border-slate-300 w-40">Поражения</th>
                                                            <td align="center" class="border border-slate-300"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="flex flex-row">
                                        <div class="flex flex-col w-full">
                                            <h1 class="text-xl text-slate-700 font-medium mb-1">Сигнатурные герои</h1>
                                            <div class="flex flex-row mb-3 w-full justify-between mb-6">
                                                <table class="border-collapse border border-slate-400 mr-8">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="border border-slate-300 underline bg-slate-100 w-60">Top</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $players_hero = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_role` = '1'");
                                                    while ($plrs_hero = mysqli_fetch_assoc($players_hero)) {
                                                    ?>
                                                        <tbody>
                                                            <tr class="">
                                                                <th align="center" class="border border-slate-300"><img class="h-20 w-20 mx-2 rounded-full drop-shadow-lg" src="heroes/<?php echo $plrs_hero["hero_name"]; ?>.png" alt="" title="<?php echo $plrs_hero["hero_name"]; ?>" /></th>
                                                                <th align="center" class="border border-slate-300 w-10">
                                                                    <?php
                                                                    $player_hero = $plrs_hero["hero_name"];
                                                                    $players_hero_check = mysqli_query($connect, "SELECT count(points) FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                    $plrs_hero_check = mysqli_fetch_row($players_hero_check);
                                                                    if ($plrs_hero_check[0] > 0) {

                                                                        $players_hero_points = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                        while ($plrs_hero_points = mysqli_fetch_assoc($players_hero_points)) {
                                                                    ?>
                                                                            <div class="radial-progress text-[10px]

                                                                            <?php
                                                                            if ($plrs_hero_points["points"] <= 10) {
                                                                            ?>
                                                                            text-green-400
                                                                            <?php
                                                                            } elseif (($plrs_hero_points["points"] > 10) && ($plrs_hero_points["points"] <= 20)) {
                                                                                ?>
                                                                                text-green-600
                                                                                <?php
                                                                                } elseif (($plrs_hero_points["points"] > 20) && ($plrs_hero_points["points"] <= 30)) {
                                                                                    ?>
                                                                                    text-yellow-400
                                                                                    <?php
                                                                                    } elseif (($plrs_hero_points["points"] > 30) && ($plrs_hero_points["points"] <= 50)) {
                                                                                        ?>
                                                                                        text-yellow-600
                                                                                        <?php
                                                                                        } elseif (($plrs_hero_points["points"] > 50) && ($plrs_hero_points["points"] <= 60)) {
                                                                                            ?>
                                                                                            text-orange-200
                                                                                            <?php
                                                                                            } elseif (($plrs_hero_points["points"] > 60) && ($plrs_hero_points["points"] <= 70)) {
                                                                                                ?>
                                                                                                text-orange-400
                                                                                                <?php
                                                                                                } elseif (($plrs_hero_points["points"] > 70) && ($plrs_hero_points["points"] <= 80)) {
                                                                                                    ?>
                                                                                                    text-orange-600
                                                                                                    <?php
                                                                                                    } elseif (($plrs_hero_points["points"] > 80) && ($plrs_hero_points["points"] <= 90)) {
                                                                                                        ?>
                                                                                                        text-red-400
                                                                                                        <?php
                                                                                                        } elseif (($plrs_hero_points["points"] > 90) && ($plrs_hero_points["points"] < 100)) {
                                                                                                            ?>
                                                                                                            text-red-600
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                            " style="--value:<?php echo $plrs_hero_points["points"]; ?>; --size:3rem; --thickness: 5px;"><?php echo $plrs_hero_points["points"]; ?>%
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="radial-progress text-[10px] text-green-400" style="--value:0; --size:3rem; --thickness: 5px;">0%
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                    }
                                                    ?>

                                                </table>

                                                <table class="border-collapse border border-slate-400 mr-8">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="border border-slate-300 underline bg-slate-100 w-60">Jungle</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $players_hero = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_role` = '2'");
                                                    while ($plrs_hero = mysqli_fetch_assoc($players_hero)) {
                                                    ?>
                                                        <tbody>
                                                            <tr class="">
                                                                <th align="center" class="border border-slate-300"><img class="h-20 w-20 mx-2 rounded-full drop-shadow-lg" src="heroes/<?php echo $plrs_hero["hero_name"]; ?>.png" alt="" title="<?php echo $plrs_hero["hero_name"]; ?>" /></th>
                                                                <th align="center" class="border border-slate-300 w-10">
                                                                    <?php
                                                                    $player_hero = $plrs_hero["hero_name"];
                                                                    $players_hero_check = mysqli_query($connect, "SELECT count(points) FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                    $plrs_hero_check = mysqli_fetch_row($players_hero_check);
                                                                    if ($plrs_hero_check[0] > 0) {

                                                                        $players_hero_points = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                        while ($plrs_hero_points = mysqli_fetch_assoc($players_hero_points)) {
                                                                    ?>
                                                                            <div class="radial-progress text-[10px]

                                                                            <?php
                                                                            if ($plrs_hero_points["points"] <= 10) {
                                                                            ?>
                                                                            text-green-400
                                                                            <?php
                                                                            } elseif (($plrs_hero_points["points"] > 10) && ($plrs_hero_points["points"] <= 20)) {
                                                                                ?>
                                                                                text-green-600
                                                                                <?php
                                                                                } elseif (($plrs_hero_points["points"] > 20) && ($plrs_hero_points["points"] <= 30)) {
                                                                                    ?>
                                                                                    text-yellow-400
                                                                                    <?php
                                                                                    } elseif (($plrs_hero_points["points"] > 30) && ($plrs_hero_points["points"] <= 50)) {
                                                                                        ?>
                                                                                        text-yellow-600
                                                                                        <?php
                                                                                        } elseif (($plrs_hero_points["points"] > 50) && ($plrs_hero_points["points"] <= 60)) {
                                                                                            ?>
                                                                                            text-orange-200
                                                                                            <?php
                                                                                            } elseif (($plrs_hero_points["points"] > 60) && ($plrs_hero_points["points"] <= 70)) {
                                                                                                ?>
                                                                                                text-orange-400
                                                                                                <?php
                                                                                                } elseif (($plrs_hero_points["points"] > 70) && ($plrs_hero_points["points"] <= 80)) {
                                                                                                    ?>
                                                                                                    text-orange-600
                                                                                                    <?php
                                                                                                    } elseif (($plrs_hero_points["points"] > 80) && ($plrs_hero_points["points"] <= 90)) {
                                                                                                        ?>
                                                                                                        text-red-400
                                                                                                        <?php
                                                                                                        } elseif (($plrs_hero_points["points"] > 90) && ($plrs_hero_points["points"] < 100)) {
                                                                                                            ?>
                                                                                                            text-red-600
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                            " style="--value:<?php echo $plrs_hero_points["points"]; ?>; --size:3rem; --thickness: 5px;"><?php echo $plrs_hero_points["points"]; ?>%
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="radial-progress text-[10px] text-green-400" style="--value:0; --size:3rem; --thickness: 5px;">0%
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>

                                                <table class="border-collapse border border-slate-400 mr-8">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="border border-slate-300 underline bg-slate-100 w-60">Middle</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $players_hero = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_role` = '3'");
                                                    while ($plrs_hero = mysqli_fetch_assoc($players_hero)) {
                                                    ?>
                                                        <tbody>
                                                            <tr class="">
                                                                <th align="center" class="border border-slate-300"><img class="h-20 w-20 mx-2 rounded-full drop-shadow-lg" src="heroes/<?php echo $plrs_hero["hero_name"]; ?>.png" alt="" title="<?php echo $plrs_hero["hero_name"]; ?>" /></th>
                                                                <th align="center" class="border border-slate-300 w-10">
                                                                    <?php
                                                                    $player_hero = $plrs_hero["hero_name"];
                                                                    $players_hero_check = mysqli_query($connect, "SELECT count(points) FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                    $plrs_hero_check = mysqli_fetch_row($players_hero_check);
                                                                    if ($plrs_hero_check[0] > 0) {

                                                                        $players_hero_points = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                        while ($plrs_hero_points = mysqli_fetch_assoc($players_hero_points)) {
                                                                    ?>
                                                                            <div class="radial-progress text-[10px]

                                                                            <?php
                                                                            if ($plrs_hero_points["points"] <= 10) {
                                                                            ?>
                                                                            text-green-400
                                                                            <?php
                                                                            } elseif (($plrs_hero_points["points"] > 10) && ($plrs_hero_points["points"] <= 20)) {
                                                                                ?>
                                                                                text-green-600
                                                                                <?php
                                                                                } elseif (($plrs_hero_points["points"] > 20) && ($plrs_hero_points["points"] <= 30)) {
                                                                                    ?>
                                                                                    text-yellow-400
                                                                                    <?php
                                                                                    } elseif (($plrs_hero_points["points"] > 30) && ($plrs_hero_points["points"] <= 50)) {
                                                                                        ?>
                                                                                        text-yellow-600
                                                                                        <?php
                                                                                        } elseif (($plrs_hero_points["points"] > 50) && ($plrs_hero_points["points"] <= 60)) {
                                                                                            ?>
                                                                                            text-orange-200
                                                                                            <?php
                                                                                            } elseif (($plrs_hero_points["points"] > 60) && ($plrs_hero_points["points"] <= 70)) {
                                                                                                ?>
                                                                                                text-orange-400
                                                                                                <?php
                                                                                                } elseif (($plrs_hero_points["points"] > 70) && ($plrs_hero_points["points"] <= 80)) {
                                                                                                    ?>
                                                                                                    text-orange-600
                                                                                                    <?php
                                                                                                    } elseif (($plrs_hero_points["points"] > 80) && ($plrs_hero_points["points"] <= 90)) {
                                                                                                        ?>
                                                                                                        text-red-400
                                                                                                        <?php
                                                                                                        } elseif (($plrs_hero_points["points"] > 90) && ($plrs_hero_points["points"] < 100)) {
                                                                                                            ?>
                                                                                                            text-red-600
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                            " style="--value:<?php echo $plrs_hero_points["points"]; ?>; --size:3rem; --thickness: 5px;"><?php echo $plrs_hero_points["points"]; ?>%
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="radial-progress text-[10px] text-green-400" style="--value:0; --size:3rem; --thickness: 5px;">0%
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>

                                                <table class="border-collapse border border-slate-400 mr-8">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="border border-slate-300 underline bg-slate-100 w-60">Carry</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $players_hero = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_role` = '4'");
                                                    while ($plrs_hero = mysqli_fetch_assoc($players_hero)) {
                                                    ?>
                                                        <tbody>
                                                            <tr class="">
                                                                <th align="center" class="border border-slate-300"><img class="h-20 w-20 mx-2 rounded-full drop-shadow-lg" src="heroes/<?php echo $plrs_hero["hero_name"]; ?>.png" alt="" title="<?php echo $plrs_hero["hero_name"]; ?>" /></th>
                                                                <th align="center" class="border border-slate-300 w-10">
                                                                    <?php
                                                                    $player_hero = $plrs_hero["hero_name"];
                                                                    $players_hero_check = mysqli_query($connect, "SELECT count(points) FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                    $plrs_hero_check = mysqli_fetch_row($players_hero_check);
                                                                    if ($plrs_hero_check[0] > 0) {

                                                                        $players_hero_points = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                        while ($plrs_hero_points = mysqli_fetch_assoc($players_hero_points)) {
                                                                    ?>
                                                                            <div class="radial-progress text-[10px]

                                                                            <?php
                                                                            if ($plrs_hero_points["points"] <= 10) {
                                                                            ?>
                                                                            text-green-400
                                                                            <?php
                                                                            } elseif (($plrs_hero_points["points"] > 10) && ($plrs_hero_points["points"] <= 20)) {
                                                                                ?>
                                                                                text-green-600
                                                                                <?php
                                                                                } elseif (($plrs_hero_points["points"] > 20) && ($plrs_hero_points["points"] <= 30)) {
                                                                                    ?>
                                                                                    text-yellow-400
                                                                                    <?php
                                                                                    } elseif (($plrs_hero_points["points"] > 30) && ($plrs_hero_points["points"] <= 50)) {
                                                                                        ?>
                                                                                        text-yellow-600
                                                                                        <?php
                                                                                        } elseif (($plrs_hero_points["points"] > 50) && ($plrs_hero_points["points"] <= 60)) {
                                                                                            ?>
                                                                                            text-orange-200
                                                                                            <?php
                                                                                            } elseif (($plrs_hero_points["points"] > 60) && ($plrs_hero_points["points"] <= 70)) {
                                                                                                ?>
                                                                                                text-orange-400
                                                                                                <?php
                                                                                                } elseif (($plrs_hero_points["points"] > 70) && ($plrs_hero_points["points"] <= 80)) {
                                                                                                    ?>
                                                                                                    text-orange-600
                                                                                                    <?php
                                                                                                    } elseif (($plrs_hero_points["points"] > 80) && ($plrs_hero_points["points"] <= 90)) {
                                                                                                        ?>
                                                                                                        text-red-400
                                                                                                        <?php
                                                                                                        } elseif (($plrs_hero_points["points"] > 90) && ($plrs_hero_points["points"] < 100)) {
                                                                                                            ?>
                                                                                                            text-red-600
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                            " style="--value:<?php echo $plrs_hero_points["points"]; ?>; --size:3rem; --thickness: 5px;"><?php echo $plrs_hero_points["points"]; ?>%
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="radial-progress text-[10px] text-green-400" style="--value:0; --size:3rem; --thickness: 5px;">0%
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>

                                                <table class="border-collapse border border-slate-400">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="border border-slate-300 underline bg-slate-100 w-60">Support</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $players_hero = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_role` = '5'");
                                                    while ($plrs_hero = mysqli_fetch_assoc($players_hero)) {
                                                    ?>
                                                        <tbody>
                                                            <tr class="">
                                                                <th align="center" class="border border-slate-300"><img class="h-20 w-20 mx-2 rounded-full drop-shadow-lg" src="heroes/<?php echo $plrs_hero["hero_name"]; ?>.png" alt="" title="<?php echo $plrs_hero["hero_name"]; ?>" /></th>
                                                                <th align="center" class="border border-slate-300 w-10">
                                                                    <?php
                                                                    $player_hero = $plrs_hero["hero_name"];
                                                                    $players_hero_check = mysqli_query($connect, "SELECT count(points) FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                    $plrs_hero_check = mysqli_fetch_row($players_hero_check);
                                                                    if ($plrs_hero_check[0] > 0) {

                                                                        $players_hero_points = mysqli_query($connect, "SELECT * FROM `players_heroes_points` WHERE `player_id` = '$player_id' AND `hero` = '$player_hero'");
                                                                        while ($plrs_hero_points = mysqli_fetch_assoc($players_hero_points)) {
                                                                    ?>
                                                                            <div class="radial-progress text-[10px]

                                                                            <?php
                                                                            if ($plrs_hero_points["points"] <= 10) {
                                                                            ?>
                                                                            text-green-400
                                                                            <?php
                                                                            } elseif (($plrs_hero_points["points"] > 10) && ($plrs_hero_points["points"] <= 20)) {
                                                                                ?>
                                                                                text-green-600
                                                                                <?php
                                                                                } elseif (($plrs_hero_points["points"] > 20) && ($plrs_hero_points["points"] <= 30)) {
                                                                                    ?>
                                                                                    text-yellow-400
                                                                                    <?php
                                                                                    } elseif (($plrs_hero_points["points"] > 30) && ($plrs_hero_points["points"] <= 50)) {
                                                                                        ?>
                                                                                        text-yellow-600
                                                                                        <?php
                                                                                        } elseif (($plrs_hero_points["points"] > 50) && ($plrs_hero_points["points"] <= 60)) {
                                                                                            ?>
                                                                                            text-orange-200
                                                                                            <?php
                                                                                            } elseif (($plrs_hero_points["points"] > 60) && ($plrs_hero_points["points"] <= 70)) {
                                                                                                ?>
                                                                                                text-orange-400
                                                                                                <?php
                                                                                                } elseif (($plrs_hero_points["points"] > 70) && ($plrs_hero_points["points"] <= 80)) {
                                                                                                    ?>
                                                                                                    text-orange-600
                                                                                                    <?php
                                                                                                    } elseif (($plrs_hero_points["points"] > 80) && ($plrs_hero_points["points"] <= 90)) {
                                                                                                        ?>
                                                                                                        text-red-400
                                                                                                        <?php
                                                                                                        } elseif (($plrs_hero_points["points"] > 90) && ($plrs_hero_points["points"] < 100)) {
                                                                                                            ?>
                                                                                                            text-red-600
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                            " style="--value:<?php echo $plrs_hero_points["points"]; ?>; --size:3rem; --thickness: 5px;"><?php echo $plrs_hero_points["points"]; ?>%
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="radial-progress text-[10px] text-green-400" style="--value:0; --size:3rem; --thickness: 5px;">0%
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                    }
                                                    ?>
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

        <script src="https://unpkg.com/flowbite@1.4.4/dist/flowbite.js"></script>

</body>

</html>