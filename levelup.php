<?php
session_start();
require_once 'config/connect.php';
require_once 'vendor/names_base.php';

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
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
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

                                <div class="flex flex-col items-center mb-10">
                                        <h1 class="text-xl text-slate-700 font-medium mb-3">1 уровень</h1>
                                        <div class="flex flex-row w-1/2 bg-white/60 transition duration-150 ease-linear backdrop-blur-xl rounded-lg justify-between">
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="1-1" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/fan1.png" alt="">
                                                </button>
                                                <div data-popover id="1-1" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 1</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            После каждой победы прибавляет 1 дополнительного фаната
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="1-2" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/money1.png" alt="">
                                                </button>
                                                <div data-popover id="1-2" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 2</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Каждая игра дополнительно приносит 1% денежных средств
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="1-3" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/cat.png" alt="">
                                                </button>
                                                <div data-popover id="1-3" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 3</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Восстанавливает 2% морали после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="1-4" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/yellowpot.png" alt="">
                                                </button>
                                                <div data-popover id="1-4" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 4</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Приносит дополнительно 1 очко опыта команды после победы
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center mb-10">
                                        <h1 class="text-xl text-slate-700 font-medium mb-3">2 уровень</h1>
                                        <div class="flex flex-row w-1/2 bg-white/60 transition duration-150 ease-linear backdrop-blur-xl rounded-lg justify-between">
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="2-1" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/fan2.png" alt="">
                                                </button>
                                                <div data-popover id="2-1" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 1</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            После каждой победы прибавляет 1 дополнительного фаната
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="2-2" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/money2.png" alt="">
                                                </button>
                                                <div data-popover id="2-2" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 2</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Каждая игра дополнительно приносит 1% денежных средств
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="2-3" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/bottle.png" alt="">
                                                </button>
                                                <div data-popover id="2-3" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 3</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Восстанавливает 2% физготовности после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="2-4" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/bluepot.png" alt="">
                                                </button>
                                                <div data-popover id="2-4" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 4</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Приносит дополнительно 1 очко опыта команды после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center mb-10">
                                        <h1 class="text-xl text-slate-700 font-medium mb-3">3 уровень</h1>
                                        <div class="flex flex-row w-1/2 bg-white/60 transition duration-150 ease-linear backdrop-blur-xl rounded-lg justify-between">
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-1" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/greenpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-1" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 1</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            После каждой победы прибавляет 1 дополнительного фаната
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-2" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/redpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-2" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 2</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Каждая игра дополнительно приносит 1% денежных средств
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-3" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/greenpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-3" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 3</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Восстанавливает 2% физготовности после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-4" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/redpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-4" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 4</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Приносит дополнительно 1 очко опыта команды после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center mb-10">
                                        <h1 class="text-xl text-slate-700 font-medium mb-3">4 уровень</h1>
                                        <div class="flex flex-row w-1/2 bg-white/60 transition duration-150 ease-linear backdrop-blur-xl rounded-lg justify-between">
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-1" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/greenpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-1" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 1</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            После каждой победы прибавляет 1 дополнительного фаната
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-2" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/redpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-2" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 2</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Каждая игра дополнительно приносит 1% денежных средств
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-3" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/greenpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-3" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 3</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Восстанавливает 2% физготовности после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <button data-popover-target="3-4" data-popover-placement="left" type="button" class="text-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <img class="object-cover object-center w-full h-20 w-20 mx-auto rounded-lg" src="img/levelup/redpot.png" alt="">
                                                </button>
                                                <div data-popover id="3-4" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300">
                                                    <div class="py-2 px-3 bg-blue-200 rounded-t-lg border-b border-gray-200 ">
                                                        <h3 class="font-semibold text-gray-900">Название способности 4</h3>
                                                    </div>
                                                    <div class="py-2 px-3">
                                                        <p>
                                                            Приносит дополнительно 1 очко опыта команды после поражения
                                                        </p>
                                                    </div>
                                                    <div data-popper-arrow></div>
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
        </div>
    </div>
    </div>
</body>

</html>