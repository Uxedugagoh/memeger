<?php
session_start();
require_once '../config/connect.php';


if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

$buildings_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$bldngs_info = mysqli_fetch_assoc($buildings_info);

$staff_info = mysqli_query($connect, "SELECT * FROM `staff` WHERE `user_id` = '$user_id'");
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

                            <?php
                            if ($bldngs_info['team_base'] == 1) {
                            ?>
                                <div class="flex flex-col h-60 w-full justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <span>Для найма первого сотрудника вам необходимо построить Базу команды-2</span>
                                </div>
                            <?php
                            } elseif ($bldngs_info['team_base'] == 2) {
                            ?>
                                <?php
                                if ($stff_info['coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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
                                <?php
                                if ($stff_info['coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($stff_info['press_secretary'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет одного дополнительного подписчика за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет одного дополнительного подписчика за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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
                                <?php
                                if ($stff_info['coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($stff_info['press_secretary'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет одного дополнительного подписчика за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет двух дополнительных подписчиков за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет двух дополнительных подписчиков за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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
                                <?php
                                if ($stff_info['coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="coach">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['coach'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Игроки, принимающие участие в матче, получают на x% больше опыта</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($stff_info['press_secretary'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет одного дополнительного подписчика за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет двух дополнительных подписчиков за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет трех дополнительных подписчиков за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="press_secretary">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['press_secretary'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/press_secretary_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Пресс секретарь-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Добавляет трех дополнительных подписчиков за победу</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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

                            

                            <?php
                            //-----------------------------------------Скаут-----------------------------------------//
                            if ($bldngs_info['office'] == 1) {
                            ?>
                                <?php
                                if ($stff_info['scout'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['office'] == 2) {
                            ?>
                                <?php
                                if ($stff_info['scout'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['office'] == 3) {
                            ?>
                                <?php
                                if ($stff_info['scout'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде пять игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="scout">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['scout'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/scout_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Скаут-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде пять игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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

                            

                            <?php
                            //-----------------------------------------Тренер молодежи-----------------------------------------//
                            if ($bldngs_info['sport_school'] == 1) {
                            ?>
                                <?php
                                if ($stff_info['youth_coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['sport_school'] == 2) {
                            ?>
                                <?php
                                if ($stff_info['youth_coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['sport_school'] == 3) {
                            ?>
                                <?php
                                if ($stff_info['youth_coach'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде трех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде четырех молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде пять молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="youth_coach">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['youth_coach'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/youth_coach_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Тренер молодежи-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ежедневно предлагает команде пять молодых игроков</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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

                            

                            <?php
                            //-----------------------------------------Психолог-----------------------------------------//
                            if ($bldngs_info['medical_center'] == 1) {
                            ?>
                                <?php
                                if ($stff_info['psychologist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['medical_center'] == 2) {
                            ?>
                                <?php
                                if ($stff_info['psychologist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['medical_center'] == 3) {
                            ?>
                                <?php
                                if ($stff_info['psychologist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="psychologist">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['psychologist'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/psychologist_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Психолог-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление морали игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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

                            

                            <?php
                            //-----------------------------------------Массажист-----------------------------------------//
                            if ($bldngs_info['medical_center'] == 1) {
                            ?>
                                <?php
                                if ($stff_info['massagist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['medical_center'] == 2) {
                            ?>
                                <?php
                                if ($stff_info['massagist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            } elseif ($bldngs_info['medical_center'] == 3) {
                            ?>
                                <?php
                                if ($stff_info['massagist'] == 0) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_1.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-1</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 2 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="1">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 1) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_2.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-2</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 8 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="2">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 2) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-yellow-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                                    <form action="../vendor/organization/staff_accept.php" method="post" class="flex justify-center items-center" enctype="multipart/form-data">
                                                        <input type="hidden" name="staff" value="massagist">
                                                        <input type="hidden" name="staff_value" value="3">
                                                        <button type="submit">
                                                            <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанять</div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($stff_info['massagist'] == 3) {
                                ?>
                                    <div class="bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30 w-full">
                                        <div class="flex p-3 border-l-8 border-green-600">
                                        <div class="flex flex-row items-center">
                                        <img class="object-cover object-center w-full h-24 w-30 mx-auto rounded-lg" src="/img/staff/massagist_3.png">
                                        </div>
                                            <div class="flex-1">
                                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                                    <div class="text-base leading-6 font-normal">Массажист-3</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Стоимость</span> 15 000</div>
                                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Преимущества</span> Ускоряет восстановление физготовности игрока на х%</div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="ml-3 my-5 bg-green-600 p-1 w-20">
                                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Нанят</div>
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