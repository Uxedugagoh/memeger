<?php
session_start();
require_once 'config/connect.php';
require_once 'vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

$team_id = (intval($_GET['id']));

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$team_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);

$staff_info = mysqli_query($connect, "SELECT * FROM `staff` WHERE `user_id` = '$team_id'");
$stff_info = mysqli_fetch_assoc($staff_info);

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
            <?php include "includes/sidebar.php"; ?>
        </div>




        <div class="w-5/6">
            <div class="p-4 text-gray-500">
                <div class="max-w-screen-2xl mx-auto">
                    <div class="relative shadow-md sm:rounded-lg">
                        <div class="p-4 flex flex-row justify-between content-center border-t">
                            <?php include "includes/topmenu.php"; ?>

                        </div>
                        <div class="p-4 flex flex-col justify-between content-center border-t">
                            <div class="flex flex-row w-full justify-around">
                                <div class="w-full bg-white/60 hover:bg-white/80 hover:shadow-lg transition duration-150 ease-linear backdrop-blur-xl right-5 top-36 rounded-lg p-6 shadow">

<div class="flex flex-row">
<a class="underline" href="matches/history.php?team_id=<?php echo $team_id; ?>">
История игр
</a>
</div>


                                    <h1 class="text-xl text-slate-700 font-medium mb-3">Игроки команды</h1>

                                    <div class="flex flex-row mb-3">
                                        <table class="border-collapse border border-slate-400 ...">
                                            <thead>
                                                <tr>
                                                    <th class="border border-slate-300 w-80 ...">Игрок</th>
                                                    <th class="border border-slate-300 px-2" title="Возраст">Воз</th>
                                                    <th class="border border-slate-300 px-2" title="Национальность">Нац</th>
                                                    <th class="border border-slate-300 px-2" title="Позиция">Поз</th>
                                                    <th class="border border-slate-300 px-2">Талант</th>
                                                    <th class="border border-slate-300 px-2" title="">Мастерство</th>
                                                    <th class="border border-slate-300 w-36" title="">Физготовность</th>
                                                    <th class="border border-slate-300 w-36" title="">Мораль</th>
                                                    <th class="border border-slate-300 px-2" title="">Бонусы</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $players_list_short = mysqli_query($connect, "SELECT * FROM `players` WHERE `user_id` = '$user_id' /*ORDER BY warehouse_id DESC*/");

                                                while ($plrs_list_short = mysqli_fetch_assoc($players_list_short)) {
                                                ?>
                                                    <tr>
                                                        <td class="border border-slate-300 pl-1 underline">
                                                            <a href="/player.php?id=<?php echo $plrs_list_short["player_id"]; ?>">
                                                                <?php echo $plrs_list_short["player_f_name"]; ?>
                                                                "<b><?php echo $plrs_list_short["player_nickname"]; ?></b>"
                                                                <?php echo $plrs_list_short["player_l_name"]; ?>
                                                            </a>
                                                        </td>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list_short["player_age"]; ?></td>
                                                        <td align="center" class="border border-slate-300">
                                                            <?php
                                                            $player_nat = $plrs_list_short["player_nationality"];
                                                            $nat_name = ${"f_name_$player_nat"}[mt_rand(0, 0)];

                                                            echo '<img class="h-5 w-8 rounded-full drop-shadow-lg" src="img/' . $player_nat . '.jpg " alt="' . $player_nat . '" title="' . $nat_name . '"/>';



                                                            ?>
                                                        </td>
                                                        <?php
                                                        $player_stamina = $plrs_list_short["player_stamina"];
                                                        $player_reaction = $plrs_list_short["player_reaction"];
                                                        $player_position_selection = $plrs_list_short["player_position_selection"];
                                                        $player_map_vision = $plrs_list_short["player_map_vision"];
                                                        $player_mechanic_knowledge = $plrs_list_short["player_mechanic_knowledge"];
                                                        $player_last_hit = $plrs_list_short["player_last_hit"];
                                                        $player_composure = $plrs_list_short["player_composure"];
                                                        $player_intuition = $plrs_list_short["player_intuition"];
                                                        $player_communication = $plrs_list_short["player_communication"];
                                                        $player_leadership = $plrs_list_short["player_leadership"];
                                                        $player_discipline = $plrs_list_short["player_discipline"];
                                                        $player_toxic_resistance = $plrs_list_short["player_toxic_resistance"];
                                                        $player_mastery = (($player_stamina + $player_reaction + $player_position_selection + $player_map_vision + $player_mechanic_knowledge + $player_last_hit + $player_composure + $player_intuition + $player_communication + $player_leadership + $player_discipline + $player_toxic_resistance) / 12);
                                                        $player_mastery = number_format($player_mastery, 0, ',', ' ');

                                                        ?>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list_short["player_position"]; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list_short["player_talent"]; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $player_mastery; ?></td>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list_short["player_physical"]; ?> %</td>
                                                        <td align="center" class="border border-slate-300"><?php echo $plrs_list_short["player_morality"]; ?> %</td>
                                                        <td align="center" class="border border-slate-300"><?php ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="flex flex-row">
                                        <table class="border-collapse border border-slate-400">
                                            <thead>
                                                <tr>
                                                    <th class="border border-slate-300 w-80">Постройки</th>
                                                    <th class="border border-slate-300 w-80">Персонал</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td align="center" class="border border-slate-300">
                                                            База команды-<?php echo $bldngs_info["team_base"]; ?> <br>
                                                            <?php
                                                            if ($bldngs_info["office"] > 0) {
                                                            ?>
                                                            Офис-<?php echo $bldngs_info["office"]; ?> <br>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($bldngs_info["sport_school"] > 0) {
                                                            ?>
                                                            Спортивная школа-<?php echo $bldngs_info["sport_school"]; ?> <br>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($bldngs_info["medical_center"] > 0) {
                                                            ?>
                                                            Медицинский центр-<?php echo $bldngs_info["medical_center"]; ?> <br>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td align="center" class="border border-slate-300">
                                                        <?php
                                                            if ($stff_info["coach"] > 0) {
                                                            ?>
                                                            Тренер-<?php echo $stff_info["coach"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($stff_info["press_secretary"] > 0) {
                                                            ?>
                                                            Пресс-секретарь-<?php echo $stff_info["press_secretary"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($stff_info["scout"] > 0) {
                                                            ?>
                                                            Скаут-<?php echo $stff_info["scout"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($stff_info["youth_coach"] > 0) {
                                                            ?>
                                                            Тренер молодежи-<?php echo $stff_info["youth_coach"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($stff_info["psychologist"] > 0) {
                                                            ?>
                                                            Психолог-<?php echo $stff_info["psychologist"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($stff_info["massagist"] > 0) {
                                                            ?>
                                                            Массажист-<?php echo $stff_info["massagist"]; ?> <br>
                                                            <?php
                                                            }
                                                        ?>
                                                        </td>
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