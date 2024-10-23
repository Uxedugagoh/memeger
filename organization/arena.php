<?php
session_start();
require_once '../config/connect.php';


if (!$_SESSION['user']['user_id']) {
    header('Location: /login.php');
}

$user_id = $_SESSION['user']['user_id'];

$arena_info = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_id'");
$arna_info = mysqli_fetch_assoc($arena_info);




$arena_keys = array();

for ($i = 0; $i < 10000; $i++) {
    $arena_keys[$i] = $i + 1;
}

$arena_levels = array();

for ($i = 0; $i < 10000; $i++) {
    if ($i == 0) {
        $arena_levels[$i] = 20;
        continue;
    }
    $arena_coef = ((20 * (1 + ($i * 0.01))) + $arena_levels[$i - 1]);
    $arena_levels[$i] = $arena_coef;
}

$finalArray = array_combine($arena_keys, $arena_levels);

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
                        <div class="p-4 flex flex-col justify-between content-center border-t flex-wrap">
                            <?php
                            if (isset($_SESSION['arena_accepted_error_1'])) {
                                echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700 justify-center" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['arena_accepted_error_1'] . '</span>
                            </div>
                        </div>';
                            }
                            unset($_SESSION['arena_accepted_error_1']);
                            ?>

                            <?php
                            if (isset($_SESSION['arena_accepted_error_2'])) {
                                echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700 justify-center" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['arena_accepted_error_2'] . '</span>
                            </div>
                        </div>';
                            }
                            unset($_SESSION['arena_accepted_error_2']);
                            ?>
                            <div class="flex flex-col mb-2">
                                <div class="flex flex-row">
                                    Текущая вместимость:
                                    <?php echo number_format($arna_info['arena'], 0, '', ' '); ?>
                                    мест
                                </div>
                            </div>

                            <form id="arena_cost" class="flex flex-col">
                                <div class="flex flex-row items-center">
                                    <input name="capacity_up" id="capacity_id" type="number" min="51" max="10000" placeholder="Введите новую вместимость" class="w-72 px-4 py-3 rounded-lg bg-gray-200 border focus:border-blue-500 focus:bg-white focus:outline-none" onchange="displayname()">
                                    <input type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md ml-1" value="Расчитать">
                                </div>
                            </form>

                            <form action="../vendor/organization/arena_accept.php" method="post" enctype="multipart/form-data" class="flex flex-col">
                                <input type="hidden" id="capacity_id_down" name="capacity" value="">
                                <input disabled id="out" name="arena_cost" placeholder="Стоимость расширения" class="w-72 px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md w-fit mt-2">
                                    Расширить
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

<script>
    var arena_levels = [<?php echo '"' . implode('","', $arena_levels) . '"' ?>];
    const cost_array = arena_levels;

    arena_cost.addEventListener('submit', evt => {
        evt.preventDefault();

        const capacity_up = arena_cost.capacity_up.value;
        const cost = cost_array[capacity_up - 1] || null;
        let cost_data = '';
        for (let key in cost) {
            cost_data += `${cost[key]}`;
        }
        let data_table = `${cost_data}`
        data_table = new Intl.NumberFormat("ru", {
            minimumFractionDigits: 2
        }).format(data_table);
        out.value = data_table
    });
</script>



<script>
    function displayname() {
        document.getElementById("capacity_id_down").value =
            document.getElementById("capacity_id").value;
    }
</script>

</html>