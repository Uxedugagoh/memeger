<?php
    session_start();
    require_once '../config/connect.php';
    require_once 'player_generation.php';

    $user_name = filter_var(trim($_POST['user_name']), FILTER_UNSAFE_RAW);
    $user_email = filter_var(trim($_POST['user_email']), FILTER_UNSAFE_RAW);
    $user_password = filter_var(trim($_POST['user_password']), FILTER_UNSAFE_RAW);
    $reuser_password = filter_var(trim($_POST['reuser_password']), FILTER_UNSAFE_RAW);

    date_default_timezone_set('Asia/Yekaterinburg');
    $reg_date = date("Y.m.d H:i:s"); 
    

    $_SESSION['user_name'] = $user_name; 
    $_SESSION['user_email'] = $user_email;


    $letters = '/^[a-zA-Zа-яёА-ЯЁ0-9]+$/u';
    $symbols = '/^[а-яА-ЯёЁa-zA-Z0-9()"№\s_-]+$/u';
    $pwsymbols = '/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
    $mailsymbols = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';

    /* Проверка названия команды */
    if(mb_strlen($user_name) < 1) {
        $_SESSION['user_name_error_1'] = 'Введите название команды';
        header('Location: ../registration.php');
    } elseif (!preg_match($letters, $user_name)) {
        $_SESSION['user_name_error_1'] = 'Недопустимые символы';
        header('Location: ../registration.php');
    } elseif(mb_strlen($user_name) < 2 || mb_strlen($user_name) > 30) {
        $_SESSION['user_name_error_1'] = 'Недопустимая длина названия команды';
        header('Location: ../registration.php');
    }

    /* Проверка почты */
    if(mb_strlen($user_email) < 1) {
        $_SESSION['user_email_error_1'] = 'Введите адрес электронной почты';
        header('Location: ../registration.php');
    }elseif (!preg_match($mailsymbols, $user_email)) {
        $_SESSION['user_email_error_1'] = 'Недопустимый формат электронной почты';
        header('Location: ../registration.php');
    }
    $check_user_email = mysqli_query($connect, "SELECT * FROM `teams` WHERE `user_email` = '$user_email'");
    if (mysqli_num_rows($check_user_email) > 0) {
        $_SESSION['user_email_error_1'] = 'Адрес электронной почты уже используется';
        header('Location: ../registration.php');
    }

    /* Проверка пароля */
    if(mb_strlen($user_password) < 1) {
        $_SESSION['user_password_error_1'] = 'Введите пароль';
        header('Location: ../registration.php');
    } elseif(mb_strlen($user_password) < 5) {
        $_SESSION['user_password_error_1'] = 'Пароль слишком простой';
        header('Location: ../registration.php');
    } elseif (!preg_match($pwsymbols, $user_password)) {
        $_SESSION['user_password_error_1'] = 'Пароль слишком простой';
        header('Location: ../registration.php');
    } elseif ($user_password != $reuser_password) {
        $_SESSION['user_password_error_1'] = 'Пароли не совпадают';
        header('Location: ../registration.php');
    } 

    
    if (!$_SESSION['password_error_1'] && !$_SESSION['user_name_error_1'] && !$_SESSION['user_email_error_1']) {
            /* Хэширование пароля */
            $user_password = md5($user_password);
            
            mysqli_query($connect, "INSERT INTO `teams` (`user_id`, `user_name`, `user_email`, `user_password`, `reg_date`) VALUES (NULL, '$user_name', '$user_email', '$user_password', '$reg_date')");
            $last_user_id = mysqli_insert_id($connect);

            mysqli_query($connect, "INSERT INTO `players` 
            (`user_id`, `player_id`, `player_f_name`,`player_nickname`, `player_l_name`,`player_age`,`player_nationality`,`player_position`,`player_talent`,`player_stamina`,`player_reaction`,`player_position_selection`,`player_map_vision`,`player_mechanic_knowledge`,`player_last_hit`,`player_composure`,`player_intuition`,`player_communication`,`player_leadership`,`player_discipline`,`player_toxic_resistance`,`player_physical`,`player_morality`,`player_experience`)
            VALUES 
            ('$last_user_id',NULL, '$random_f_name_1', '$random_nickname_1','$random_l_name_1', '$first_age', '$generate_player_1', 'Top',  '$first_tal', '$first_mas_1', '$first_mas_2', '$first_mas_3', '$first_mas_4', '$first_mas_5', '$first_mas_6', '$first_mas_7', '$first_mas_8', '$first_mas_9', '$first_mas_10', '$first_mas_11', '$first_mas_12','100','100','0'),
            ('$last_user_id',NULL, '$random_f_name_2', '$random_nickname_2','$random_l_name_2', '$second_age', '$generate_player_2', 'Jungle',  '$second_tal', '$second_mas_1', '$second_mas_2', '$second_mas_3', '$second_mas_4', '$second_mas_5', '$second_mas_6', '$second_mas_7', '$second_mas_8', '$second_mas_9', '$second_mas_10', '$second_mas_11', '$second_mas_12','100','100','0'),
            ('$last_user_id',NULL, '$random_f_name_3', '$random_nickname_3','$random_l_name_3', '$third_age', '$generate_player_3', 'Middle',  '$third_tal', '$third_mas_1', '$third_mas_2', '$third_mas_3', '$third_mas_4', '$third_mas_5', '$third_mas_6', '$third_mas_7', '$third_mas_8', '$third_mas_9', '$third_mas_10', '$third_mas_11', '$third_mas_12','100','100','0'),
            ('$last_user_id',NULL, '$random_f_name_4', '$random_nickname_4','$random_l_name_4', '$fifth_age', '$generate_player_4', 'Carry',  '$fourth_tal', '$fourth_mas_1', '$fourth_mas_2', '$fourth_mas_3', '$fourth_mas_4', '$fourth_mas_5', '$fourth_mas_6', '$fourth_mas_7', '$fourth_mas_8', '$fourth_mas_9', '$fourth_mas_10', '$fourth_mas_11', '$fourth_mas_12','100','100','0'),
            ('$last_user_id',NULL, '$random_f_name_5', '$random_nickname_5','$random_l_name_5', '$fifth_age', '$generate_player_5', 'Support',  '$fifth_tal', '$fifth_mas_1', '$fifth_mas_2', '$fifth_mas_3', '$fifth_mas_4', '$fifth_mas_5', '$fifth_mas_6', '$fifth_mas_7', '$fifth_mas_8', '$fifth_mas_9', '$fifth_mas_10', '$fifth_mas_11', '$fifth_mas_12','100','100','0'),
            ('$last_user_id',NULL, '$random_f_name_6', '$random_nickname_6','$random_l_name_6', '$sixth_age', '$generate_player_6', '$random_position',  '$sixth_tal', '$sixth_mas_1', '$sixth_mas_2', '$sixth_mas_3', '$sixth_mas_4', '$sixth_mas_5', '$sixth_mas_6', '$sixth_mas_7', '$sixth_mas_8', '$sixth_mas_9', '$sixth_mas_10', '$sixth_mas_11', '$sixth_mas_12','100','100','0')");

            mysqli_query($connect, "INSERT INTO `staff` (`operation_id`, `user_id`, `coach`, `press_secretary`, `scout`, `youth_coach`, `psychologist`, `massagist`) VALUES (NULL, '$last_user_id', 0, 0, 0, 0, 0, 0)");

            mysqli_query($connect, "INSERT INTO `buildings` (`operation_id`, `user_id`, `team_base`, `office`, `sport_school`, `medical_center`, `arena`) VALUES (NULL, '$last_user_id', 1, 0, 0, 0, 50)");



mysqli_close($connect);
        
            $_SESSION['registration_complete'] = 'Вы зарегистрированы!';
            header('Location: ../login.php'); 
    }

?>