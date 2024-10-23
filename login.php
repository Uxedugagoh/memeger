<?php
    session_start();
    require_once 'config/connect.php';

    if (isset($_SESSION['user']['user_id'])) {
        header('Location: user.php?id=' . $_SESSION['user']['user_id'] );
    }
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
    <title>Вход</title>
</head>

<body class="antialiased bg-gray-100">
    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow shadow-slate-300">
        <div class="flex flex-row items-center">
        </div>
    <form action="vendor/signin.php" method="post" class="">
            <div class="flex flex-col space-y-1">

                <?php
                if (isset ($_SESSION['registration_complete'])) {
                    echo '<div class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">'. $_SESSION['registration_complete'] .'</span>
                            </div>
                        </div>';
                }
                unset($_SESSION['registration_complete']);
                ?>

                <label for="user_email">
                    <p class="font-medium text-slate-700 pb-2">
                        Адрес электронной почты
                    </p>
                    <input id="user_email" name="user_email" type="email"
                        class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow"
                        placeholder="Введите адрес электронной почты" />
                </label>
                <?php
                if (isset ($_SESSION['user_email_error_2'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">'. $_SESSION['user_email_error_2'] .'</span>
                            </div>
                        </div>';
                }
                unset($_SESSION['user_email_error_2']);
                ?>


                <label class="" for="user_password">
                    <p class="font-medium text-slate-700 pb-2">Пароль</p>
                    <input id="user_password" name="user_password" type="password"
                        class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow"
                        placeholder="Введите пароль" />
                </label>

                <?php
                if (isset ($_SESSION['user_password_error_2'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">'. $_SESSION['user_password_error_2'] .'</span>
                            </div>
                        </div>';
                }
                unset($_SESSION['user_password_error_2']);
                ?>


                <?php
                if (isset ($_SESSION['signin_error'])) {
                    echo '<div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <span class="font-medium">'. $_SESSION['signin_error'] .'</span>
                            </div>
                        </div>';
                }
                unset($_SESSION['signin_error']);
                ?>

                <div class="pt-4">
                    <button
                        class="w-full py-3 font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg border-indigo-500 hover:shadow inline-flex space-x-2 items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Войти</span>
                    </button>
                </div>

                <p class="text-center">
                    Еще нет аккаунта?
                    <a href="/registration.php"
                        class="text-indigo-600 font-medium inline-flex space-x-1 items-center"><span>Зарегистрироваться</span><span><svg
                                xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg></span></a>
                </p>
            </div>
        </form>
    </div>
</body>

</html>