<?php
session_start();
require_once 'config/connect.php';
require_once 'vendor/names_base.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: login.php');
}

$user_id = $_SESSION['user']['user_id'];
$hero_id = (intval($_GET['id']));

$hero_details = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_id` = '$hero_id' /*ORDER BY warehouse_id DESC*/");
$hro_details = mysqli_fetch_assoc($hero_details);
$hero_name = $hro_details["hero_name"];



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
                        <div class="p-4 flex flex-row justify-center content-center border-t flex-wrap">


                            <div class="max-w-2xl bg-white rounded-lg shadow-md">
                                <img class="object-cover w-full h-64" src="heroes/<?php echo $hero_name; ?>.png" alt="<?php echo $hero_name; ?>">

                                <div class="p-6">
                                    <div>
                                        <span class="text-xs font-medium text-blue-600 uppercase">Прозвище</span>
                                        <a class="block text-2xl font-semibold text-gray-800 transition-colors duration-300 transform -mt-2" tabindex="0" role="link"><?php echo $hero_name; ?></a>
                                        <p class="mt-2 text-sm text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Molestie parturient et sem ipsum volutpat vel. Natoque sem et aliquam mauris egestas quam volutpat viverra. In pretium nec senectus erat. Et malesuada lobortis.</p>
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex items-center mb-2">
                                            <div class="flex items-center">
                                                <img class="object-cover h-10 rounded-full" src="heroes/<?php echo $hero_name; ?>.png" alt="<?php echo $hero_name; ?>">
                                                <a class="mx-2 font-semibold text-gray-700" tabindex="0" role="link">Способность 1</a>
                                            </div>
                                            <span class="mx-1 text-xs text-gray-600 uppercase">описание пассивки</span>
                                        </div>
                                        <div class="flex items-center my-2">
                                            <div class="flex items-center">
                                                <img class="object-cover h-10 rounded-full" src="heroes/<?php echo $hero_name; ?>.png" alt="<?php echo $hero_name; ?>">
                                                <a class="mx-2 font-semibold text-gray-700" tabindex="0" role="link">Способность 2</a>
                                            </div>
                                            <span class="mx-1 text-xs text-gray-600 uppercase">описание пассивки</span>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <div class="flex items-center">
                                                <img class="object-cover h-10 rounded-full" src="heroes/<?php echo $hero_name; ?>.png" alt="<?php echo $hero_name; ?>">
                                                <a class="mx-2 font-semibold text-gray-700" tabindex="0" role="link">Способность 3</a>
                                            </div>
                                            <span class="mx-1 text-xs text-gray-600 uppercase">описание пассивки</span>
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