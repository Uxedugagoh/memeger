<?php
session_start();
require_once '../config/connect.php';


if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);



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
                            <div class="flex flex-row justify-center w-full">
                                <?php
                                if (isset($_SESSION['building_accepted_error_1'])) {
                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['building_accepted_error_1'] . '</span>
                            </div>
                        </div>';
                                }
                                unset($_SESSION['building_accepted_error_1']);
                                ?>

                                <?php
                                if (isset($_SESSION['building_accepted_error_2'])) {
                                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['building_accepted_error_2'] . '</span>
                            </div>
                        </div>';
                                }
                                unset($_SESSION['building_accepted_error_2']);
                                ?>
                            </div>

                            <?php if ($bldngs_info['team_base'] == 1) {
                            ?>
                                <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                    <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex-1">
                                            <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                <div class="text-base leading-6 font-normal">БАЗА КОМАНДЫ-2</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 5 000</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет увеличить масимальное число игроков в команде до 7 человек, добавляет 3-х свободных агентов, открывает возможность построить Базу команды-3, открывает возможность построить Офис-1, открывает возможность нанять Тренера-1, открывает возможность увеличить максимальный размер арены до 2 000</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center items-center">
                                            <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                    <input type="hidden" name="building" value="team_base">
                                                    <input type="hidden" name="building_value" value="2">
                                                    <button type="submit">
                                                        <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } elseif ($bldngs_info['team_base'] == 2) {
                            ?>
                                <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                    <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex-1">
                                            <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                <div class="text-base leading-6 font-normal">БАЗА КОМАНДЫ-3</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 10 000</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет увеличить масимальное число игроков в команде до 8 человек, добавляет 4-х свободных агентов, открывает возможность построить Базу команды-4, открывает возможность построить Офис-2, открывает возможность построить Спортивную школу-1, открывает возможность построить Медицинский центр-1, открывает возможность нанять Тренера-2, открывает возможность нанять Пресс-секретаря-1, открывает возможность увеличить максимальный размер арены до 3 500</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center items-center">
                                            <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                    <input type="hidden" name="building" value="team_base">
                                                    <input type="hidden" name="building_value" value="3">
                                                    <button type="submit">
                                                        <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($bldngs_info['office'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            <?php
                            } elseif ($bldngs_info['team_base'] == 3) {
                            ?>
                                <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                    <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex-1">
                                            <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                <div class="text-base leading-6 font-normal">БАЗА КОМАНДЫ-4</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет увеличить масимальное число игроков в команде до 9 человек, добавляет 5-х свободных агентов, открывает возможность построить Базу команды-5, открывает возможность построить Офис-3, открывает возможность построить Спортивную школу-2, открывает возможность построить Медицинский центр-2, открывает возможность нанять Тренера-3, открывает возможность нанять Пресс-секретаря-2, открывает возможность увеличить максимальный размер арены до 5 000</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center items-center">
                                            <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                    <input type="hidden" name="building" value="team_base">
                                                    <input type="hidden" name="building_value" value="4">
                                                    <button type="submit">
                                                        <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($bldngs_info['office'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 5 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 5 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['sport_school'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['medical_center'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-1, Массажиста-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-1, Массажиста-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['team_base'] == 4) {
                            ?>
                                <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                    <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex-1">
                                            <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                <div class="text-base leading-6 font-normal">БАЗА КОМАНДЫ-5</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 40 000</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет увеличить масимальное число игроков в команде до 10 человек, добавляет 6-х свободных агентов, открывает возможность построить Спортивную школу-3, открывает возможность построить Медицинский центр-3, открывает возможность нанять Пресс-секретаря-3, открывает возможность увеличить максимальный размер арены до 10 000</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center items-center">
                                            <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                    <input type="hidden" name="building" value="team_base">
                                                    <input type="hidden" name="building_value" value="5">
                                                    <button type="submit">
                                                        <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($bldngs_info['office'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 5 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 10 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 10 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['sport_school'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['medical_center'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-1, Массажиста-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-2, Массажиста-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-2, Массажиста-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


                            <?php
                            } elseif ($bldngs_info['team_base'] == 5) {
                            ?>
                                <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                    <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-40 mx-auto rounded-lg" src="/img/buildings/team_base_5.png">
                                        </div>
                                        <div class="flex-1">
                                            <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                <div class="text-base leading-6 font-normal">БАЗА КОМАНДЫ-5</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 40 000</div>
                                                <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет увеличить масимальное число игроков в команде до 10 человек, добавляет 6-х свободных агентов, открывает возможность построить Спортивную школу-3, открывает возможность построить Медицинский центр-3, открывает возможность нанять Пресс-секретаря-3, открывает возможность увеличить максимальный размер арены до 10 000</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center items-center">
                                            <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($bldngs_info['office'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 5 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 10 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="office">
                                                        <input type="hidden" name="building_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['office'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">ОФИС-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 10 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Позволяет нанять Скаута-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['sport_school'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 50 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="sport_school">
                                                        <input type="hidden" name="building_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['sport_school'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">СПОРТИВНАЯ ШКОЛА-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 50 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Тренера молодежи-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($bldngs_info['medical_center'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 20 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-1, Массажиста-1</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 30 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-2, Массажиста-2</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 50 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-3, Массажиста-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/building_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="building" value="medical_center">
                                                        <input type="hidden" name="building_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построить</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($bldngs_info['medical_center'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-40 mx-auto rounded-lg" src="/img/buildings/medical_center_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">МЕДИЦИНСКИЙ ЦЕНТР-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 50 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Открывает возможность нанять Психолога-3, Массажиста-3</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Построено</div>
                                                </div>
                                            </div>
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
    </div>
</body>

</html>