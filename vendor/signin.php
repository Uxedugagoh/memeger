<?php
    session_start();
    require_once '../config/connect.php';

    $user_email = filter_var(trim($_POST['user_email']), FILTER_UNSAFE_RAW);
    $user_password = filter_var(trim($_POST['user_password']), FILTER_UNSAFE_RAW);

    $mailsymbols = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';
    $pwsymbols = '/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';

    if(mb_strlen($user_email) < 1) {
        $_SESSION['user_email_error_2'] = 'Введите адрес электронной почты';
        header('Location: ../login.php');
    } elseif (!preg_match($mailsymbols, $user_email)) {
        $_SESSION['user_email_error_2'] = 'Недопустимый формат электронной почты';
        header('Location: ../login.php');
    }
    
    if(mb_strlen($user_password) < 1) {
        $_SESSION['user_password_error_2'] = 'Введите пароль';
        header('Location: ../login.php');    
    }

    $user_password = md5($_POST['user_password']);

    if (!$_SESSION['user_email_error_2'] && !$_SESSION['user_password_error_2'] /* && !$_SESSION['captcha_error_2'] */) {
        $check_user = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_email` = '$user_email' AND `user_password` = '$user_password'");
    

    if (mysqli_num_rows($check_user) >0) {
        
        $user = mysqli_fetch_assoc($check_user);
        
        $_SESSION['user'] = [
            "user_id" => $user['user_id'],
            "user_email" => $user['user_email']
        ];
        
        header('Location: ../team.php?id=' . $_SESSION['user']['user_id']);
        
    }   else {
        $_SESSION['signin_error'] = 'Неверный логин или пароль';
        header('Location: ../login.php');
    }
    }






















?>