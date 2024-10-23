<?php
session_start();
require_once '../config/connect.php';
require_once '../vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];


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

$training_keys = array();

for ($i = 0; $i < 99; $i++) {
    $training_keys[$i] = $i + 2;
}

$training_levels = array();

for ($i = 0; $i < 99; $i++) {
    $training_coef = 30 * (2 + ($i * 0.01));
    $training_levels[$i] = $training_coef;
}

$finalArray = array_combine($training_keys, $training_levels);

*/

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
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="icon" href="/img/favicon.png" type="image/png">
    <title>Тренировка</title>
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
                                    <h1 class="text-xl text-slate-700 font-medium mb-3">Тренировка</h1>
                                    <?php
                                    if (isset($_SESSION['training_error'])) {
                                        echo '<div class="flex bg-red-100 rounded-lg p-4 text-sm text-red-700 w-full" role="alert">
                                                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                            <div>
                                                                <span class="font-medium">' . $_SESSION['training_error'] . '</span>
                                                            </div>
                                                            </div>';
                                    }
                                    unset($_SESSION['training_error']);
                                    ?>

                                    <div class="flex flex-row">
                                        <table class="border-collapse border border-slate-400">
                                            <thead>
                                                <tr>
                                                    <th class="border border-slate-300 w-64">Игрок</th>
                                                    <th class="border border-slate-300 px-2" title="Возраст">Воз</th>
                                                    <th class="border border-slate-300 px-2" title="Национальность">Нац</th>
                                                    <th class="border border-slate-300 px-2" title="Позиция">Поз</th>
                                                    <th class="border border-slate-300 px-2" title="Талант">Тал</th>
                                                    <th class="border border-slate-300 px-2" title="Мастерство">Мас</th>
                                                    <th class="border border-slate-300 px-2">Опыт</th>
                                                    <th class="border border-slate-300 w-16" title="Выносливость">Вын</th>
                                                    <th class="border border-slate-300 w-16" title="Реакция">Реа</th>
                                                    <th class="border border-slate-300 w-16" title="Выбор позиции">Выб</th>
                                                    <th class="border border-slate-300 w-16" title="Видение карты">Вид</th>
                                                    <th class="border border-slate-300 w-16" title="Знание механик">Зна</th>
                                                    <th class="border border-slate-300 w-16" title="Добивание">Доб</th>
                                                    <th class="border border-slate-300 w-16" title="Самообладание">Сам</th>
                                                    <th class="border border-slate-300 w-16" title="Интуиция">Инт</th>
                                                    <th class="border border-slate-300 w-16" title="Коммуникация">Ком</th>
                                                    <th class="border border-slate-300 w-16" title="Лидерство">Лид</th>
                                                    <th class="border border-slate-300 w-16" title="Дисциплина">Дис</th>
                                                    <th class="border border-slate-300 w-16" title="Токсик резистентность">Ток</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $players_list = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = '$user_id' /*ORDER BY warehouse_id DESC*/");

                                                while ($plrs_list = mysqli_fetch_assoc($players_list)) {
                                                ?>
                                                    <tr>
                                                            <td class="border border-slate-300 h-16 pl-1 underline">
                                                            <a href="/player.php?id=<?php echo $plrs_list["player_id"]; ?>">
                                                                <?php echo $plrs_list["player_f_name"]; ?> 
                                                                "<b><?php echo $plrs_list["player_nickname"]; ?></b>" 
                                                                <?php echo $plrs_list["player_l_name"]; ?>
                                                                </a>
                                                            </td>
                                                        
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list["player_age"]; ?></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <?php
                                                            $player_nat = $plrs_list["player_nationality"];
                                                            $nat_name = ${"f_name_$player_nat"}[mt_rand(0, 0)];

                                                            echo '<img class="h-5 w-8 mx-2 rounded-full drop-shadow-lg" title="' . $nat_name . '" src="../img/' . $player_nat . '.jpg " alt="' . $player_nat . '"/>';
                                                            ?>
                                                        </td>
                                                        <td align="center" align="center" class="border border-slate-300"><?php echo $plrs_list["player_position"]; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list["player_talent"]; ?></td>
                                                        <?php
                                                        $player_stamina = $plrs_list["player_stamina"];
                                                        $player_reaction = $plrs_list["player_reaction"];
                                                        $player_position_selection = $plrs_list["player_position_selection"];
                                                        $player_map_vision = $plrs_list["player_map_vision"];
                                                        $player_mechanic_knowledge = $plrs_list["player_mechanic_knowledge"];
                                                        $player_last_hit = $plrs_list["player_last_hit"];
                                                        $player_composure = $plrs_list["player_composure"];
                                                        $player_intuition = $plrs_list["player_intuition"];
                                                        $player_communication = $plrs_list["player_communication"];
                                                        $player_leadership = $plrs_list["player_leadership"];
                                                        $player_discipline = $plrs_list["player_discipline"];
                                                        $player_toxic_resistance = $plrs_list["player_toxic_resistance"];
                                                        $player_mastery = (($player_stamina + $player_reaction + $player_position_selection + $player_map_vision + $player_mechanic_knowledge + $player_last_hit + $player_composure + $player_intuition + $player_communication + $player_leadership + $player_discipline + $player_toxic_resistance) / 12);
                                                        $player_mastery = number_format($player_mastery, 0, ',', ' ');

                                                        ?>
                                                        <td align="center" class="border border-slate-300 font-bold text-green-600"><?php echo $player_mastery; ?></td>
                                                        <td align="center" class="border border-slate-300 bg-green-600 text-white"><?php echo $plrs_list["player_experience"]; ?></td>
                                                        <td align="center" class="border border-slate-300 
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_stamina"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>
                                                                ">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">

                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_stamina"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_stamina';
                                                                                $ability_level = $plrs_list["player_stamina"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_stamina"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_stamina"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_stamina"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_stamina"] + 1], 0, ',', ' '); ?></div>
                                                            </div>
                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_reaction"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>
                                                        ">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_reaction"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_reaction';
                                                                                $ability_level = $plrs_list["player_reaction"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_reaction"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_reaction"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_reaction"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_reaction"] + 1], 0, ',', ' '); ?></div>
                                                            </div>
                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_position_selection"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>
                                                        ">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_position_selection"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_position_selection';
                                                                                $ability_level = $plrs_list["player_position_selection"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_position_selection"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_position_selection"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_position_selection"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_position_selection"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_map_vision"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_map_vision"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_map_vision';
                                                                                $ability_level = $plrs_list["player_map_vision"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_map_vision"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_map_vision"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_map_vision"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_map_vision"] + 1], 0, ',', ' '); ?></div>
                                                            </div>
                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_mechanic_knowledge"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_mechanic_knowledge"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_mechanic_knowledge';
                                                                                $ability_level = $plrs_list["player_mechanic_knowledge"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_mechanic_knowledge"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_mechanic_knowledge"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_mechanic_knowledge"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_mechanic_knowledge"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_last_hit"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_last_hit"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_last_hit';
                                                                                $ability_level = $plrs_list["player_last_hit"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_last_hit"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_last_hit"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_last_hit"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_last_hit"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_composure"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_composure"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_composure';
                                                                                $ability_level = $plrs_list["player_composure"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_composure"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_composure"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_composure"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_composure"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_intuition"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_intuition"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_intuition';
                                                                                $ability_level = $plrs_list["player_intuition"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_intuition"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_intuition"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_intuition"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_intuition"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_communication"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_communication"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_communication';
                                                                                $ability_level = $plrs_list["player_communication"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_communication"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_communication"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_communication"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_communication"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_leadership"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_leadership"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_leadership';
                                                                                $ability_level = $plrs_list["player_leadership"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_leadership"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_leadership"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_leadership"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_leadership"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_discipline"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_discipline"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_discipline';
                                                                                $ability_level = $plrs_list["player_discipline"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_discipline"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_discipline"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_discipline"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_discipline"] + 1], 0, ',', ' '); ?></div>
                                                            </div>

                                                        </td>
                                                        <td align="center" class="border border-slate-300
                                                        <?php
                                                        if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_toxic_resistance"] + 1]) {
                                                        ?>
                                                            bg-yellow-400
                                                        <?php
                                                        }
                                                        ?>">
                                                            <div class="flex-flex-col">
                                                                <div class="flex flex-row justify-center items-center font-bold">
                                                                    <?php
                                                                    if ($plrs_list["player_experience"] >= $training_array_straight[$plrs_list["player_toxic_resistance"] + 1]) {
                                                                    ?>
                                                                        <form action="../vendor/players/training_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                                            <button type="submit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <?php
                                                                                $player_id = $plrs_list["player_id"];
                                                                                $player_ability = 'player_toxic_resistance';
                                                                                $ability_level = $plrs_list["player_toxic_resistance"] + 1;
                                                                                $experience_spent = $training_array_straight[$plrs_list["player_toxic_resistance"] + 1];
                                                                                $remaining_experience = $plrs_list["player_experience"] - $training_array_straight[$plrs_list["player_toxic_resistance"] + 1];
                                                                                ?>
                                                                                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                                                                                <input type="hidden" name="player_ability" value="<?php echo $player_ability; ?>">
                                                                                <input type="hidden" name="ability_level" value="<?php echo $ability_level; ?>">
                                                                                <input type="hidden" name="experience_spent" value="<?php echo $experience_spent; ?>">
                                                                                <input type="hidden" name="remaining_experience" value="<?php echo $remaining_experience; ?>">
                                                                            </button>
                                                                        </form>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php echo $plrs_list["player_toxic_resistance"]; ?>
                                                                </div>
                                                                <div class="text-xs -mt-1 font-light"><?php echo number_format($training_array_straight[$plrs_list["player_toxic_resistance"] + 1], 0, ',', ' '); ?></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
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

    <script src="https://unpkg.com/flowbite@1.4.4/dist/flowbite.js"></script>

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

</body>

</html>