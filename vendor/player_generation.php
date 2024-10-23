<?php

require_once 'names_base.php';


//Генерация никнейма

function nickname_gen()
{
    $symbol_arr = array('aeiouy', 'bcdfghjklmnpqrstvwxz');
    $length = mt_rand(3, 9);
    $return = array();
    foreach ($symbol_arr as $k => $v)
        $symbol_arr[$k] = str_split($v);
    for ($i = 0; $i < $length; $i++) {
        while (true) {
            $symbol_x = mt_rand(0, sizeof($symbol_arr) - 1);
            $symbol_y = mt_rand(0, sizeof($symbol_arr[$symbol_x]) - 1);
            if ($i > 0 && in_array($return[$i - 1], $symbol_arr[$symbol_x]))
                continue;
            $return[] = $symbol_arr[$symbol_x][$symbol_y];
            break;
        }
    }
    $return = ucfirst(implode('', $return));
    return $return;
}

$random_nickname_1 = nickname_gen();
$random_nickname_2 = nickname_gen();
$random_nickname_3 = nickname_gen();
$random_nickname_4 = nickname_gen();
$random_nickname_5 = nickname_gen();
$random_nickname_6 = nickname_gen();
$random_nickname_7 = nickname_gen();
$random_nickname_8 = nickname_gen();
$random_nickname_9 = nickname_gen();
$random_nickname_10 = nickname_gen();
$random_nickname_11 = nickname_gen();


/*
$generate_nickname_1 = array_rand($nickname);
$random_nickname_1 = $nickname[$generate_nickname_1];
$generate_nickname_2 = array_rand($nickname);
$random_nickname_2 = $nickname[$generate_nickname_2];
$generate_nickname_3 = array_rand($nickname);
$random_nickname_3 = $nickname[$generate_nickname_3];
$generate_nickname_4 = array_rand($nickname);
$random_nickname_4 = $nickname[$generate_nickname_4];
$generate_nickname_5 = array_rand($nickname);
$random_nickname_5 = $nickname[$generate_nickname_5];
$generate_nickname_6 = array_rand($nickname);
$random_nickname_6 = $nickname[$generate_nickname_6];
$generate_nickname_7 = array_rand($nickname);
$random_nickname_7 = $nickname[$generate_nickname_7];
$generate_nickname_8 = array_rand($nickname);
$random_nickname_8 = $nickname[$generate_nickname_8];
$generate_nickname_9 = array_rand($nickname);
$random_nickname_9 = $nickname[$generate_nickname_9];
$generate_nickname_10 = array_rand($nickname);
$random_nickname_10 = $nickname[$generate_nickname_10];
$generate_nickname_11 = array_rand($nickname);
$random_nickname_11 = $nickname[$generate_nickname_11];
*/


//Генерация имени, фамилии и национальности

$random_nationality_1 = rand(1, 100);
if ($random_nationality_1 >= 60) {
    $nationality_array_1 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_1 >= 30 && $random_nationality_1 < 60) {
    $nationality_array_1 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_1 >= 15 && $random_nationality_1 < 30) {
    $nationality_array_1 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_1 >= 5 && $random_nationality_1 < 15) {
    $nationality_array_1 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_1 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_2 = rand(1, 100);
if ($random_nationality_2 >= 60) {
    $nationality_array_2 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_2 >= 30 && $random_nationality_2 < 60) {
    $nationality_array_2 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_2 >= 15 && $random_nationality_2 < 30) {
    $nationality_array_2 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_2 >= 5 && $random_nationality_2 < 15) {
    $nationality_array_2 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_2 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_3 = rand(1, 100);
if ($random_nationality_3 >= 60) {
    $nationality_array_3 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_3 >= 30 && $random_nationality_3 < 60) {
    $nationality_array_3 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_3 >= 15 && $random_nationality_3 < 30) {
    $nationality_array_3 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_3 >= 5 && $random_nationality_3 < 15) {
    $nationality_array_3 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_3 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_4 = rand(1, 100);
if ($random_nationality_4 >= 60) {
    $nationality_array_4 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_4 >= 30 && $random_nationality_4 < 60) {
    $nationality_array_4 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_4 >= 15 && $random_nationality_4 < 30) {
    $nationality_array_4 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_4 >= 5 && $random_nationality_4 < 15) {
    $nationality_array_4 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_4 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_5 = rand(1, 100);
if ($random_nationality_5 >= 60) {
    $nationality_array_5 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_5 >= 30 && $random_nationality_5 < 60) {
    $nationality_array_5 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_5 >= 15 && $random_nationality_5 < 30) {
    $nationality_array_5 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_5 >= 5 && $random_nationality_5 < 15) {
    $nationality_array_5 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_5 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_6 = rand(1, 100);
if ($random_nationality_6 >= 60) {
    $nationality_array_6 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_6 >= 30 && $random_nationality_6 < 60) {
    $nationality_array_6 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_6 >= 15 && $random_nationality_6 < 30) {
    $nationality_array_6 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_6 >= 5 && $random_nationality_6 < 15) {
    $nationality_array_6 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_6 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_7 = rand(1, 100);
if ($random_nationality_7 >= 60) {
    $nationality_array_7 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_7 >= 30 && $random_nationality_7 < 60) {
    $nationality_array_7 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_7 >= 15 && $random_nationality_7 < 30) {
    $nationality_array_7 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_7 >= 5 && $random_nationality_7 < 15) {
    $nationality_array_7 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_7 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_8 = rand(1, 100);
if ($random_nationality_8 >= 60) {
    $nationality_array_8 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_8 >= 30 && $random_nationality_8 < 60) {
    $nationality_array_8 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_8 >= 15 && $random_nationality_8 < 30) {
    $nationality_array_8 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_8 >= 5 && $random_nationality_8 < 15) {
    $nationality_array_8 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_8 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_9 = rand(1, 100);
if ($random_nationality_9 >= 60) {
    $nationality_array_9 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_9 >= 30 && $random_nationality_9 < 60) {
    $nationality_array_9 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_9 >= 15 && $random_nationality_9 < 30) {
    $nationality_array_9 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_9 >= 5 && $random_nationality_9 < 15) {
    $nationality_array_9 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_9 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_10 = rand(1, 100);
if ($random_nationality_10 >= 60) {
    $nationality_array_10 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_10 >= 30 && $random_nationality_10 < 60) {
    $nationality_array_10 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_10 >= 15 && $random_nationality_10 < 30) {
    $nationality_array_10 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_10 >= 5 && $random_nationality_10 < 15) {
    $nationality_array_10 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_10 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$random_nationality_11 = rand(1, 100);
if ($random_nationality_11 >= 60) {
    $nationality_array_11 = $seeding_1; // вероятность выпадения первой корзины - 40%
} elseif ($random_nationality_11 >= 30 && $random_nationality_11 < 60) {
    $nationality_array_11 = $seeding_2; // вероятность выпадения второй корзины - 30%
} elseif ($random_nationality_11 >= 15 && $random_nationality_11 < 30) {
    $nationality_array_11 = $seeding_3; // вероятность выпадения третьей корзины - 15%
} elseif ($random_nationality_11 >= 5 && $random_nationality_11 < 15) {
    $nationality_array_11 = $seeding_4; // вероятность выпадения четвертой корзины - 10%
} else $nationality_array_11 = $seeding_5; // вероятность выпадения пятой корзины - 5%

$generate_player_1 = $nationality_array_1[array_rand($nationality_array_1)];
$generate_player_2 = $nationality_array_2[array_rand($nationality_array_2)];
$generate_player_3 = $nationality_array_3[array_rand($nationality_array_3)];
$generate_player_4 = $nationality_array_4[array_rand($nationality_array_4)];
$generate_player_5 = $nationality_array_5[array_rand($nationality_array_5)];
$generate_player_6 = $nationality_array_6[array_rand($nationality_array_6)];
$generate_player_7 = $nationality_array_7[array_rand($nationality_array_7)];
$generate_player_8 = $nationality_array_8[array_rand($nationality_array_8)];
$generate_player_9 = $nationality_array_9[array_rand($nationality_array_9)];
$generate_player_10 = $nationality_array_10[array_rand($nationality_array_10)];
$generate_player_11 = $nationality_array_11[array_rand($nationality_array_11)];


$random_f_name_1 = ${"f_name_$generate_player_1"}[mt_rand(1, 10)];
$random_l_name_1 = ${"l_name_$generate_player_1"}[mt_rand(1, 10)];
$nat_name_1 = ${"f_name_$generate_player_1"}[mt_rand(0, 0)];

$random_f_name_2 = ${"f_name_$generate_player_2"}[mt_rand(1, 10)];
$random_l_name_2 = ${"l_name_$generate_player_2"}[mt_rand(1, 10)];
$nat_name_2 = ${"f_name_$generate_player_2"}[mt_rand(0, 0)];

$random_f_name_3 = ${"f_name_$generate_player_3"}[mt_rand(1, 10)];
$random_l_name_3 = ${"l_name_$generate_player_3"}[mt_rand(1, 10)];
$nat_name_3 = ${"f_name_$generate_player_3"}[mt_rand(0, 0)];

$random_f_name_4 = ${"f_name_$generate_player_4"}[mt_rand(1, 10)];
$random_l_name_4 = ${"l_name_$generate_player_4"}[mt_rand(1, 10)];
$nat_name_4 = ${"f_name_$generate_player_4"}[mt_rand(0, 0)];

$random_f_name_5 = ${"f_name_$generate_player_5"}[mt_rand(1, 10)];
$random_l_name_5 = ${"l_name_$generate_player_5"}[mt_rand(1, 10)];
$nat_name_5 = ${"f_name_$generate_player_5"}[mt_rand(0, 0)];

$random_f_name_6 = ${"f_name_$generate_player_6"}[mt_rand(1, 10)];
$random_l_name_6 = ${"l_name_$generate_player_6"}[mt_rand(1, 10)];
$nat_name_6 = ${"f_name_$generate_player_6"}[mt_rand(0, 0)];

$random_f_name_7 = ${"f_name_$generate_player_7"}[mt_rand(1, 10)];
$random_l_name_7 = ${"l_name_$generate_player_7"}[mt_rand(1, 10)];
$nat_name_7 = ${"f_name_$generate_player_7"}[mt_rand(0, 0)];

$random_f_name_8 = ${"f_name_$generate_player_8"}[mt_rand(1, 10)];
$random_l_name_8 = ${"l_name_$generate_player_8"}[mt_rand(1, 10)];
$nat_name_8 = ${"f_name_$generate_player_8"}[mt_rand(0, 0)];

$random_f_name_9 = ${"f_name_$generate_player_9"}[mt_rand(1, 10)];
$random_l_name_9 = ${"l_name_$generate_player_9"}[mt_rand(1, 10)];
$nat_name_9 = ${"f_name_$generate_player_9"}[mt_rand(0, 0)];

$random_f_name_10 = ${"f_name_$generate_player_10"}[mt_rand(1, 10)];
$random_l_name_10 = ${"l_name_$generate_player_10"}[mt_rand(1, 10)];
$nat_name_10 = ${"f_name_$generate_player_10"}[mt_rand(0, 0)];

$random_f_name_11 = ${"f_name_$generate_player_11"}[mt_rand(1, 10)];
$random_l_name_11 = ${"l_name_$generate_player_11"}[mt_rand(1, 10)];
$nat_name_11 = ${"f_name_$generate_player_11"}[mt_rand(0, 0)];


//Генерация позиции шестого игрока
$random_position = $player_sixth_position[mt_rand(0, 4)];


//Генерация возраста
function ArrayAgeGen()
{
    $arr_age = array();
    for ($i = 0; $i < 6; $i++) {
        $arr_age[$i] = mt_rand(16, 28);
    }
    return $arr_age;
}

function GenAge()
{
    $array_age = array();
    $age_summ = 0;
    while (true) {
        for ($i = 0; $i < sizeof($array_age); $i++) {
            $age_summ += $array_age[$i];
        }
        if ($age_summ >= 120 && $age_summ <= 130)
            return $array_age;
        else {
            $age_summ = 0;
            $array_age = ArrayAgeGen();
            continue;
        }
    }
}

$age = GenAge();
$first_age = $age[0];
$second_age = $age[1];
$third_age = $age[2];
$fourth_age = $age[3];
$fifth_age = $age[4];
$sixth_age = $age[5];

$age_sum = array_sum($age);
$age_sum_avg = $age_sum/6;
$age_sum_avg = number_format($age_sum_avg, 2, ',',' ');


//Генерация таланта
/*
function talant()
{
    $random_talant = rand(1, 1001);
    if ($random_talant == 1001) {
        $number_1 = 10; // вероятность выпадения 10 - 0,1%
        return $number_1;
    } elseif ($random_talant >= 997 && $random_talant <= 1000) {
        $number_1 = 9; // вероятность выпадения 9 - 0,25%
        return $number_1;
    } elseif ($random_talant >= 986 && $random_talant <= 996) {
        $number_1 = 8; // вероятность выпадения 8 - 1%
        return $number_1;
    } elseif ($random_talant >= 955 && $random_talant <= 985) {
        $number_1 = 7; // вероятность выпадения 7 - 3%
        return $number_1;
    } elseif ($random_talant >= 904 && $random_talant <= 954) {
        $number_1 = 6; // вероятность выпадения 6 - 5%
        return $number_1;
    } elseif ($random_talant >= 833 && $random_talant <= 903) {
        $number_1 = 5; // вероятность выпадения 5 - 7%
        return $number_1;
    } elseif ($random_talant >= 682 && $random_talant <= 832) {
        $number_1 = 4; // вероятность выпадения 4 - 15%
        return $number_1;
    } elseif ($random_talant >= 481 && $random_talant <= 681) {
        $number_1 = 3; // вероятность выпадения 3 - 20%
        return $number_1;
    } elseif ($random_talant >= 246 && $random_talant <= 480) {
        $number_1 = 2; // вероятность выпадения 2 - 23,38%
        return $number_1;
    } else $number_1 = 1; // вероятность выпадения 1 - 25,27%
    return $number_1;
}

$talant_1 = talant();
$talant_2 = talant();
$talant_3 = talant();
$talant_4 = talant();
$talant_5 = talant();
$talant_6 = talant();
$talant_7 = talant();
$talant_8 = talant();
$talant_9 = talant();
$talant_10 = talant();
$talant_11 = talant();
*/

function ArrayTalGen()
{
    $arr_tal = array();
    for ($i = 0; $i < 6; $i++) {
        $arr_tal[$i] = mt_rand(1, 7);
    }
    return $arr_tal;
}

function GenTal()
{
    $array_tal = array();
    $tal_summ = 0;
    while (true) {
        for ($i = 0; $i < sizeof($array_tal); $i++) {
            $tal_summ += $array_tal[$i];
        }
        if ($tal_summ >= 24 && $tal_summ <= 24)
            return $array_tal;
        else {
            $tal_summ = 0;
            $array_tal = ArrayTalGen();
            continue;
        }
    }
}

$talant = GenTal();
$first_tal = $talant[0];
$second_tal = $talant[1];
$third_tal = $talant[2];
$fourth_tal = $talant[3];
$fifth_tal = $talant[4];
$sixth_tal = $talant[5];

$talant_sum = array_sum($talant);
$talant_sum_avg = $talant_sum/6;
$talant_sum_avg = number_format($talant_sum_avg, 2, ',',' ');




//Генерация мастерства
function ArrayMasGen()
{
    $arr_mas = array();
    for ($i = 0; $i < 12; $i++) {
        $arr_mas[$i] = mt_rand(7, 13);
    }
    return $arr_mas;
}

function GenMas()
{
    $array_mas = array();
    $mas_summ = 0;
    while (true) {
        for ($i = 0; $i < sizeof($array_mas); $i++) {
            $mas_summ += $array_mas[$i];
        }
        if ($mas_summ >= 110 && $mas_summ <= 130)
            return $array_mas;
        else {
            $mas_summ = 0;
            $array_mas = ArrayMasGen();
            continue;
        }
    }
}

$player_mas_1 = GenMas();
$player_mas_1_sum = array_sum($player_mas_1);
$player_mas_1_sum_avg = $player_mas_1_sum/12;
$player_mas_1_sum_avg = number_format($player_mas_1_sum_avg, 2, ',',' ');
$first_mas_1 = $player_mas_1[0];
$first_mas_2 = $player_mas_1[1];
$first_mas_3 = $player_mas_1[2];
$first_mas_4 = $player_mas_1[3];
$first_mas_5 = $player_mas_1[4];
$first_mas_6 = $player_mas_1[5];
$first_mas_7 = $player_mas_1[6];
$first_mas_8 = $player_mas_1[7];
$first_mas_9 = $player_mas_1[8];
$first_mas_10 = $player_mas_1[9];
$first_mas_11 = $player_mas_1[10];
$first_mas_12 = $player_mas_1[11];

$player_mas_2 = GenMas();
$player_mas_2_sum = array_sum($player_mas_2);
$player_mas_2_sum_avg = $player_mas_2_sum/12;
$player_mas_2_sum_avg = number_format($player_mas_2_sum_avg, 2, ',',' ');
$second_mas_1 = $player_mas_2[0];
$second_mas_2 = $player_mas_2[1];
$second_mas_3 = $player_mas_2[2];
$second_mas_4 = $player_mas_2[3];
$second_mas_5 = $player_mas_2[4];
$second_mas_6 = $player_mas_2[5];
$second_mas_7 = $player_mas_2[6];
$second_mas_8 = $player_mas_2[7];
$second_mas_9 = $player_mas_2[8];
$second_mas_10 = $player_mas_2[9];
$second_mas_11 = $player_mas_2[10];
$second_mas_12 = $player_mas_2[11];

$player_mas_3 = GenMas();
$player_mas_3_sum = array_sum($player_mas_3);
$player_mas_3_sum_avg = $player_mas_3_sum/12;
$player_mas_3_sum_avg = number_format($player_mas_3_sum_avg, 2, ',',' ');
$third_mas_1 = $player_mas_3[0];
$third_mas_2 = $player_mas_3[1];
$third_mas_3 = $player_mas_3[2];
$third_mas_4 = $player_mas_3[3];
$third_mas_5 = $player_mas_3[4];
$third_mas_6 = $player_mas_3[5];
$third_mas_7 = $player_mas_3[6];
$third_mas_8 = $player_mas_3[7];
$third_mas_9 = $player_mas_3[8];
$third_mas_10 = $player_mas_3[9];
$third_mas_11 = $player_mas_3[10];
$third_mas_12 = $player_mas_3[11];

$player_mas_4 = GenMas();
$player_mas_4_sum = array_sum($player_mas_4);
$player_mas_4_sum_avg = $player_mas_4_sum/12;
$player_mas_4_sum_avg = number_format($player_mas_4_sum_avg, 2, ',',' ');
$fourth_mas_1 = $player_mas_4[0];
$fourth_mas_2 = $player_mas_4[1];
$fourth_mas_3 = $player_mas_4[2];
$fourth_mas_4 = $player_mas_4[3];
$fourth_mas_5 = $player_mas_4[4];
$fourth_mas_6 = $player_mas_4[5];
$fourth_mas_7 = $player_mas_4[6];
$fourth_mas_8 = $player_mas_4[7];
$fourth_mas_9 = $player_mas_4[8];
$fourth_mas_10 = $player_mas_4[9];
$fourth_mas_11 = $player_mas_4[10];
$fourth_mas_12 = $player_mas_4[11];

$player_mas_5 = GenMas();
$player_mas_5_sum = array_sum($player_mas_5);
$player_mas_5_sum_avg = $player_mas_5_sum/12;
$player_mas_5_sum_avg = number_format($player_mas_5_sum_avg, 2, ',',' ');
$fifth_mas_1 = $player_mas_5[0];
$fifth_mas_2 = $player_mas_5[1];
$fifth_mas_3 = $player_mas_5[2];
$fifth_mas_4 = $player_mas_5[3];
$fifth_mas_5 = $player_mas_5[4];
$fifth_mas_6 = $player_mas_5[5];
$fifth_mas_7 = $player_mas_5[6];
$fifth_mas_8 = $player_mas_5[7];
$fifth_mas_9 = $player_mas_5[8];
$fifth_mas_10 = $player_mas_5[9];
$fifth_mas_11 = $player_mas_5[10];
$fifth_mas_12 = $player_mas_5[11];

$player_mas_6 = GenMas();
$player_mas_6_sum = array_sum($player_mas_6);
$player_mas_6_sum_avg = $player_mas_6_sum/12;
$player_mas_6_sum_avg = number_format($player_mas_6_sum_avg, 2, ',',' ');
$sixth_mas_1 = $player_mas_6[0];
$sixth_mas_2 = $player_mas_6[1];
$sixth_mas_3 = $player_mas_6[2];
$sixth_mas_4 = $player_mas_6[3];
$sixth_mas_5 = $player_mas_6[4];
$sixth_mas_6 = $player_mas_6[5];
$sixth_mas_7 = $player_mas_6[6];
$sixth_mas_8 = $player_mas_6[7];
$sixth_mas_9 = $player_mas_6[8];
$sixth_mas_10 = $player_mas_6[9];
$sixth_mas_11 = $player_mas_6[10];
$sixth_mas_12 = $player_mas_6[11];

$team_mas_sum = ($player_mas_1_sum + $player_mas_2_sum + $player_mas_3_sum + $player_mas_4_sum + $player_mas_5_sum + $player_mas_6_sum)/12;
$team_mas_sum_avg = $team_mas_sum/6;
$team_mas_sum_avg = number_format($team_mas_sum_avg, 2, ',',' ');
?>