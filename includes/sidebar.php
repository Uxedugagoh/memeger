<?php

$user_id = $_SESSION['user']['user_id'];
$user_info = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_id` = '$user_id'");
$usr_info = mysqli_fetch_assoc($user_info);

$team_id = $usr_info['user_id'];

?>

<div class="sticky top-0">
    <div class="flex items-center space-x-4 p-2 mb-5">
        <div class="min-w-min flex flex-col">
            <div class="flex flex-row">
                <h4 class="font-semibold text-lg text-gray-700 capitalize font-poppins tracking-wide overflow-x-hidden pr-1"><?= $usr_info['user_name'] ?></h4>
                <h4 class="font-semibold text-lg text-gray-700 capitalize font-poppins tracking-wide overflow-x-hidden">[<?= '1' ?>]</h4>
            </div>
            <span class="text-sm tracking-wide flex items-center space-x-1">
                <span class="text-gray-600"><?= 'Uxedugagoh is wathcing' ?></span>
            </span>
        </div>
    </div>
    <ul class="space-y-2 text-sm">

        <div class="border-b py-2">
            <li class="pb-2">
                <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner

                <?php
                $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                if (strpos($url, 'main.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                }
                ?>

                ">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>

                    </span>
                    <span>Главная (Пока нет)</span>
                </a>
            </li>
            <li class="pb-2">
                <a href="/team.php?id=<?php echo $team_id; ?>" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner
                
                <?php
                if (strpos($url, 'team.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'maintenance.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'defect_adding_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'defect_archive.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'defect_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'defect_updating_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'folder_adding_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'folder_updating_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'object_adding_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'object_updating_page.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                } elseif (strpos($url, 'object.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                }
                ?>

                ">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <span>Профиль</span>
                </a>
            </li>
        </div>

        <div class="border-b py-2">
            <li class="pb-2">
                <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner
                
                <?php
                if (strpos($url, 'library.php') != false) {
                    echo 'bg-gray-200 shadow-outline shadow-inner';
                }
                ?>

                ">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                    </span>
                    <div class="flex justify-between w-1/2">
                        <span>Деньги:</span>
                    </div>
                    <div class="flex justify-end w-1/2">
                        <span class="font-mono font-bold text-blue-900"><?php
                                                            $user_money = $usr_info['user_money'];
                                                            $user_money = number_format($user_money, 0, ',', ' ');
                                                            echo $user_money;
                                                            ?></span>
                    </div>
                </a>
            </li>
            <li class="pb-2">
                <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                        </svg>
                    </span>
                    <div class="flex justify-between w-1/2">
                        <span>Очки сезона:</span>
                    </div>
                    <div class="flex justify-end w-1/2">
                        <span class="font-mono font-bold text-blue-900"><?php
                                                            $user_points = $usr_info['user_points'];
                                                            $user_points = number_format($user_points, 0, ',', ' ');
                                                            echo $user_points;
                                                            ?></span>
                    </div>
                </a>
            </li>
            <li class="pb-2">
                <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </span>
                    <div class="flex justify-between w-1/2">
                        <span>Опыт:</span>
                    </div>
                    <div class="flex justify-end w-1/2">
                        <span class="font-mono font-bold text-blue-900"><?php
                                                            $user_exp = $usr_info['user_exp'];
                                                            $user_exp = number_format($user_exp, 0, ',', ' ');
                                                            echo $user_exp;
                                                            ?></span>
                    </div>
                </a>
            </li>
            <li class="pb-2">
                <a href="" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner">
                    <span class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </span>
                    <div class="flex justify-between w-1/2">
                        <span>Подписчики:</span>
                    </div>
                    <div class="flex justify-end w-1/2">
                        <span class="font-mono font-bold text-blue-900"><?php
                                                            $user_fans = $usr_info['user_fans'];
                                                            $user_fans = number_format($user_fans, 0, ',', ' ');
                                                            echo $user_fans;
                                                            ?></span>
                    </div>
                </a>
            </li>
        </div>


        <li>
            <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner
            
            <?php
            if (strpos($url, 'settings.php') != false) {
                echo 'bg-gray-200 shadow-outline shadow-inner';
            }
            ?>
            
            ">
                <span class="text-gray-600">
                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                        </path>
                    </svg>
                </span>
                <span>Настройки (пока нет)</span>
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner
            
            <?php
            if (strpos($url, 'password_change_page.php') != false) {
                echo 'bg-gray-200 shadow-outline shadow-inner';
            }
            ?>
            
            ">
                <span class="text-gray-600">
                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <span>Изменить пароль (Пока нет)</span>
            </a>
        </li>
        <li>
            <a href="/vendor/logout.php" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-inner">
                <span class="text-gray-600">
                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </span>
                <span>Выход</span>
            </a>
        </li>
    </ul>
</div>