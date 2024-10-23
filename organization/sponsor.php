<?php
session_start();
require_once '../config/connect.php';


if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];





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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                                <div class="relative mx-auto w-full">
                                    <a href="#" class="relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full">
                                        <div class="shadow p-4 rounded-lg bg-white">
                                            <div class="flex justify-center relative rounded-lg overflow-hidden h-52">
                                                <div class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full">
                                                    <div class="absolute inset-0 bg-black opacity-10"></div>
                                                </div>
                                                <div class="absolute flex justify-center bottom-0 mb-3">
                                                    <div class="flex bg-white px-4 py-1 space-x-5 rounded-lg overflow-hidden shadow">
                                                        <p class="flex items-center font-medium text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                            </svg>

                                                            11
                                                        </p>

                                                        <p class="flex items-center font-medium text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                                            </svg>

                                                            100%
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <h2 class="font-medium text-base md:text-lg text-gray-800 line-clamp-1" title="New York">
                                                    Имя спонсора
                                                </h2>
                                                <p class="mt-2 text-sm text-gray-800 line-clamp-1" title="New York, NY 10004, United States">
                                                    Описание спонсора
                                                </p>
                                            </div>

                                            <div class="grid grid-cols-1 grid-rows-1 gap-4 mt-8">
                                                <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-400 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                                                    </svg>

                                                    <span class="mt-2 xl:mt-0">
                                                        Бафф
                                                    </span>
                                                </p>
                                                <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-400 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" />
                                                    </svg>

                                                    <span class="mt-2 xl:mt-0">
                                                        Дебафф
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="grid grid-cols-2 mt-8">
                                                <div class="flex items-center">
                                                    <p class="ml-2 text-gray-800 line-clamp-1 text-sm">
                                                        Штраф при расторжении контракта
                                                    </p>
                                                </div>

                                                <div class="flex justify-end items-end">
                                                    <p class="inline-block font-semibold text-primary whitespace-nowrap leading-tight rounded-xl">
                                                        <span class="text-sm uppercase">
                                                        </span>
                                                        <span class="text-lg">3 200</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
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