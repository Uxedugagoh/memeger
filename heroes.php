<?php
session_start();
require_once 'config/connect.php';

if (!$_SESSION['user']['user_id']) {
    header('Location: login.php');
}

$user_id = $_SESSION['user']['user_id'];

$hero_details = mysqli_query($connect, "SELECT * FROM `heroes`");



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
                        <div class="p-4 flex flex-row justify-between content-center border-t flex-wrap">


                        <?php
                            while ($hro_details = mysqli_fetch_assoc($hero_details)) {
                                $hero_name = $hro_details["hero_name"];
                            ?>
                            <a href="/hero.php?id=<?php echo $hro_details["hero_id"]; ?>">
                            <div class="w-full max-w-xs text-center mb-5">
                                <img class="object-cover object-center w-full h-48 w-80 mx-auto rounded-lg" src="heroes/<?php echo $hero_name; ?>.png" alt="<?php echo $hero_name; ?>">
                                <div class="">
                                    <h3 class="text-lg font-medium text-gray-700"><?php echo $hro_details["hero_name"]; ?></h3>
                                    <div class="text-gray-600 text-sm font-light -mt-2">Прозвище</div>
                                </div>
                            </div>
                            </a>
                            <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>