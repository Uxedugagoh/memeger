<?php
session_start();
require_once 'config/connect.php';

if (isset($_SESSION['user']['user_id'])) {
    header('Location: user.php?id=' . $_SESSION['user']['user_id'] );
}

$user_name = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "";
$user_email = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : "";

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="icon" href="/img/favicon.png" type="image/png">
    <title>Регистрация</title>
</head>

<body class="antialiased bg-gray-100">
    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow shadow-slate-300">
    <div class="flex flex-row items-center">

        </div>
        <form action="vendor/signup.php" method="post" class="" enctype="multipart/form-data">
            <div class="flex flex-col space-y-1">


                    <label for="user_name">
                        <div class="flex flex-row">
                            <p class="font-medium text-slate-700 pb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                Название команды
                            </p>
                        </div>
                        <input id="user_name" name="user_name" type="text" value="<?php echo $user_name;
                        unset($_SESSION['user_name']); ?>" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Введите название команды" />
                    </label>


                <?php
                if (isset($_SESSION['user_name_error_1'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['user_name_error_1'] . '</span>
                            </div>
                            </div>';
                }
                unset($_SESSION['user_name_error_1']);
                ?>
                <label for="user_email">
                    <div class="flex flex-row">
                        <p class="font-medium text-slate-700 pb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                            Адрес электронной почты
                        </p>
                    </div>
                    <input id="user_email" name="user_email" type="email" value="<?php echo $user_email;
                                                                        unset($_SESSION['user_email']); ?>" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Введите адрес электронной почты" />
                </label>
                <?php
                if (isset($_SESSION['user_email_error_1'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['user_email_error_1'] . '</span>
                            </div>
                            </div>';
                }
                unset($_SESSION['user_email_error_1']);
                ?>

                <div class="flex flex-row flex-nowrap justify-between space-x-3">
                    <label for="user_password">
                        <div class="flex flex-row">
                            <p class="font-medium text-slate-700 pb-2 after:content-['*'] after:ml-0.5 after:text-red-500">Пароль</p>
                        </div>
                        <input id="user_password" name="user_password" type="password" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Введите пароль" />
                    </label>
                    <label for="reuser_password">
                        <div class="flex flex-row">
                            <p class="font-medium text-slate-700 pb-2 after:content-['*'] after:ml-0.5 after:text-red-500">Подтвердите пароль</p>
                        </div>
                        <input id="reuser_password" name="reuser_password" type="password" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Введите пароль еще раз" />
                    </label>
                </div>


                <?php
                if (isset($_SESSION['user_password_error_1'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">' . $_SESSION['user_password_error_1'] . '</span>
                            </div>
                        </div>';
                }
                unset($_SESSION['user_password_error_1']);
                ?>


                <div class="pt-4">
                    <button class="w-full py-3 font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg border-indigo-500 hover:shadow inline-flex space-x-2 items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <span>Зарегистрироваться</span>
                    </button>
                </div>

                <p class="text-center">
                    Уже есть аккаунт?
                    <a href="/login.php" class="text-indigo-600 font-medium inline-flex space-x-1 items-center"><span>Войти</span><span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg></span></a>
                </p>
            </div>
        </form>
    </div>
</body>

</html>