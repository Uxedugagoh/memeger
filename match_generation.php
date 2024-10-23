<?php

use Character as GlobalCharacter;

include "mechanics.php";

$game_id = (intval($_GET['game_id']));

    $game_player_list = mysqli_query($connect, "SELECT player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10 FROM `games` WHERE `game_id` = '$game_id'");
    $gm_player_list = mysqli_fetch_assoc($game_player_list);

    for ($i = 1; $i <= sizeof($gm_player_list); $i++) {
        $temp = 'player_' . $i;
        ${"player_id_$i"} = $gm_player_list[$temp];

        ${"game_player_info_$i"} = mysqli_query($connect, "SELECT * FROM `players` WHERE `player_id` = ${"player_id_$i"}");
        ${"gm_player_info_$i"} = mysqli_fetch_assoc(${"game_player_info_$i"});
        ${"gm_player_info_$i"} = array_values(${"gm_player_info_$i"});
    }

    $game_hero_list = mysqli_query($connect, "SELECT hero_1, hero_2, hero_3, hero_4, hero_5, hero_6, hero_7, hero_8, hero_9, hero_10 FROM `games` WHERE `game_id` = '$game_id'");
    $gm_hero_list = mysqli_fetch_assoc($game_hero_list);

    for ($i = 1; $i <= sizeof($gm_hero_list); $i++) {
        $temp = 'hero_' . $i;
        ${"hero_name_$i"} = $gm_hero_list[$temp];

        ${"game_hero_info_$i"} = mysqli_query($connect, "SELECT * FROM `heroes` WHERE `hero_name` = '${"hero_name_$i"}'");
        ${"gm_hero_info_$i"} = mysqli_fetch_assoc(${"game_hero_info_$i"});
        ${"gm_hero_info_$i"} = array_values(${"gm_hero_info_$i"});
    }

    $mastery_status = mysqli_query($connect, "SELECT player_hero_1, player_hero_2, player_hero_3, player_hero_4, player_hero_5, player_hero_6, player_hero_7, player_hero_8, player_hero_9, player_hero_10 FROM `games` WHERE `game_id` = '$game_id'");
    $mstry_status = mysqli_fetch_assoc($mastery_status);

    for ($i = 1; $i <= sizeof($mstry_status); $i++) {
        $temp = 'player_hero_' . $i;
        ${"player_mastery_$i"} = $mstry_status[$temp];
    }

    $junglers_stats = mysqli_query($connect, "SELECT jungle_a_1, jungle_d_1, jungle_a_2, jungle_d_2 FROM `games` WHERE `game_id` = '$game_id'");
    $jnglrs_stats = mysqli_fetch_assoc($junglers_stats);
    $jungle_a_1 = $jnglrs_stats['jungle_a_1'];
    $jungle_d_1 = $jnglrs_stats['jungle_d_1'];
    $jungle_a_2 = $jnglrs_stats['jungle_a_2'];
    $jungle_d_2 = $jnglrs_stats['jungle_d_2'];

    $captains_status = mysqli_query($connect, "SELECT captain_1, captain_2 FROM `games` WHERE `game_id` = '$game_id'");
    $cptns_status = mysqli_fetch_assoc($captains_status);
    $captain_1 = $cptns_status['captain_1'];
    $captain_2 = $cptns_status['captain_2'];

    $opponent_awaiting = mysqli_query($connect, "SELECT * FROM `games` WHERE `game_id` = '$game_id'");
    $oppnnt_awaiting = mysqli_fetch_assoc($opponent_awaiting);
    $user_1_id = $oppnnt_awaiting['user_1'];
    $arena_capacity = mysqli_query($connect, "SELECT * FROM `buildings` WHERE `user_id` = '$user_1_id'");
    $arn_capacity = mysqli_fetch_assoc($arena_capacity); // $arn_capacity['arena'] - вмсетимость арены

    if ($oppnnt_awaiting['game_type'] == 1) {
        $spectators = (($tm_1_name['user_fans'] * 0.05) + ($tm_2_name['user_fans'] * 0.02)); //посещаесость матча фанатами обеих команд
        $spectators = round($spectators);
        if ($spectators > $arn_capacity) {
            $spectators = $arn_capacity;
        }
    }


    $teamArray = array();
    $teamArray2 = array();
    for($i = 1; $i <= 10; $i++)
    {
        if($i <= 5)
        { 
            $teamArray[$i - 1] = PlayersDataConvertation(${"gm_player_info_$i"}, ${"player_mastery_$i"});
            array_values($teamArray[$i - 1]);
            continue;
        }
        else
        {
            $teamArray2[$i - 6] = PlayersDataConvertation(${"gm_player_info_$i"}, ${"player_mastery_$i"});
            array_values($teamArray2[$i - 6]);
        }
    }

    for ($i = 1; $i <= 5; $i++)
    {
        $teamArray[$i - 1] = MoralAndPhysImpact($teamArray, $i - 1, ${"gm_player_info_$i"});
    }
    for ($i = 6; $i <= 10; $i++)
    {
        $teamArray2[$i - 6] = MoralAndPhysImpact($teamArray2, $i - 6, ${"gm_player_info_$i"});
    }
    
    
    $CaptainOfTeam = array();
    $CaptainOfTeam2 = array();
    for($i = 1; $i <= 10; $i++)
    {
        if($i <= 5)
        {
            $CaptainOfTeam[$i - 1] = CaptainArrayCreator(${"gm_player_info_$i"}, $captain_1);
        }
        else
        {
            $CaptainOfTeam2[$i - 5] = CaptainArrayCreator(${"gm_player_info_$i"}, $captain_2);
        }
    }

    $teamName = "Звери Владислава Бритова (жёсткие)";  //Эти две переменные определить через запрос из базы данных.
    $teamName2 = "Пачка негров";


    $characterOrder = array();
    $characterOrder2 = array();
    for($i = 1; $i <= 10; $i++)
    {
        ${"gm_hero_info_$i"} = CharacterDataConvertation(${"gm_hero_info_$i"});
    }
    for($i = 1; $i <= 10; $i++)
    {
        if($i <= 5)
        {
            array_push($characterOrder,  ${"gm_hero_info_$i"});
        }
        else
        {
            array_push($characterOrder2,  ${"gm_hero_info_$i"});
        }
    }
    $characterOrder = array_values($characterOrder);
    $characterOrder2 = array_values($characterOrder2);
    
    $teamArray = PLayerStatsCalc($teamArray, $CaptainOfTeam);
    $teamArray2 = PLayerStatsCalc($teamArray2, $CaptainOfTeam2);
    

    $arraycharacters = CharacterConvert($characterOrder, $teamArray);
    $arraycharacters2 = CharacterConvert($characterOrder2, $teamArray2);
    $arraycharacters = MapVisionBuff($arraycharacters, $teamArray);
    $arraycharacters2 = MapVisionBuff($arraycharacters2, $teamArray2);
    $arraycharacters = TeamDefenition($teamArray, $arraycharacters, $teamName);
    $arraycharacters2 = TeamDefenition($teamArray2, $arraycharacters2, $teamName2);


/*--------------------------- Начало матча ---------------------------*/
$arraycharacters = TeamGen($arraycharacters);
$arraycharacters2 = TeamGen($arraycharacters2);
$TotalScore = new TotalScore(0, 0);
/*--------------------------- Начало первой стадии ---------------------------*/

    EarlyAbilitiesFirstPrio($arraycharacters, $arraycharacters2);
    EarlyAbilitiesSecondPrio($arraycharacters, $arraycharacters2);
    EarlyAbilitiesThirdPrio($arraycharacters, $arraycharacters2);
    JunglerStatsGive($arraycharacters, $jungle_a_1 - 1, $jungle_d_1 - 1);
    JunglerStatsGive($arraycharacters2, $jungle_a_2 - 1, $jungle_d_2 - 1);
    SupportStatsGive($arraycharacters);
    SupportStatsGive($arraycharacters2);
    EarlyAbilitiesSpecialPrio($arraycharacters, $arraycharacters2);
    EarlyStageCalculation($arraycharacters, $arraycharacters2);

    $top_a_1_1 = $arraycharacters[0]->attack_points;
    $top_d_1_1 = $arraycharacters[0]->defence_points;
    $jungle_a_1_1 = 0;
    $jungle_d_1_1 = 0;
    $middle_a_1_1 = $arraycharacters[2]->attack_points;
    $middle_d_1_1 = $arraycharacters[2]->defence_points;
    $carry_a_1_1 = $arraycharacters[3]->attack_points;
    $carry_d_1_1 = $arraycharacters[3]->defence_points;
    $support_a_1_1 = 0;
    $support_d_1_1 = 0;

    $top_a_2_1 = $arraycharacters2[0]->attack_points;
    $top_d_2_1 = $arraycharacters2[0]->defence_points;
    $jungle_a_2_1 = 0;
    $jungle_d_2_1 = 0;
    $middle_a_2_1 = $arraycharacters2[2]->attack_points;
    $middle_d_2_1 = $arraycharacters2[2]->defence_points;
    $carry_a_2_1 = $arraycharacters2[3]->attack_points;
    $carry_d_2_1 = $arraycharacters2[3]->defence_points;
    $support_a_2_1 = 0;
    $support_d_2_1 = 0;

    EarlyGameEnd($arraycharacters, $arraycharacters2, $TotalScore, $jungle_a_1, $jungle_d_1, $jungle_a_2, $jungle_d_2);
    $TotalScore->TotalScoreCheck();

/*--------------------------- Конец первой стадии ---------------------------*/

$top_points_1_1 = CoeffConvert($arraycharacters[0]->EarlyStageCoeff);
$jungle_points_1_1 = CoeffConvert($arraycharacters[1]->EarlyStageCoeff);
$middle_points_1_1 = CoeffConvert($arraycharacters[2]->EarlyStageCoeff);
$carry_points_1_1 = CoeffConvert($arraycharacters[3]->EarlyStageCoeff);
$support_points_1_1 = CoeffConvert($arraycharacters[4]->EarlyStageCoeff);

$top_points_2_1 = CoeffConvert($arraycharacters2[0]->EarlyStageCoeff);
$jungle_points_2_1 = CoeffConvert($arraycharacters2[1]->EarlyStageCoeff);
$middle_points_2_1 = CoeffConvert($arraycharacters2[2]->EarlyStageCoeff);
$carry_points_2_1 = CoeffConvert($arraycharacters2[3]->EarlyStageCoeff);
$support_points_2_1 = CoeffConvert($arraycharacters2[4]->EarlyStageCoeff);

/*--------------------------- Начало второй стадии ---------------------------*/
    MidAbilitiesFirstPrio($arraycharacters, $arraycharacters2);
    MidStageCalculation($arraycharacters, $arraycharacters2);
    MidAbilitiesSecondPrio($arraycharacters, $arraycharacters2);
    MidAbilitiesThirdPrio($arraycharacters, $arraycharacters2);
    MidAbilitiesSpecialPrio($arraycharacters, $arraycharacters2);
    MidStageEnd($arraycharacters, $arraycharacters2, $TotalScore);
    $TotalScore->TotalScoreCheck();
/*--------------------------- Конец второй стадии ---------------------------*/

$top_farm_1 = $arraycharacters[0]->MidGameFarm;
$jungle_farm_1 = $arraycharacters[1]->MidGameFarm;
$middle_farm_1 = $arraycharacters[2]->MidGameFarm;
$carry_farm_1 = $arraycharacters[3]->MidGameFarm;
$support_farm_1 = $arraycharacters[4]->MidGameFarm;

$top_farm_2 = $arraycharacters2[0]->MidGameFarm;
$jungle_farm_2 = $arraycharacters2[1]->MidGameFarm;
$middle_farm_2 = $arraycharacters2[2]->MidGameFarm;
$carry_farm_2 = $arraycharacters2[3]->MidGameFarm;
$support_farm_2 = $arraycharacters2[4]->MidGameFarm;

/*--------------------------- Начало третьей стдии ---------------------------*/
        if ($TotalScore->LateStageCheck()) { // Проверка на 2-0
                LateAbilitiesFirstPrio($arraycharacters, $arraycharacters2);
                FarmConvert($arraycharacters);
                FarmConvert($arraycharacters2);
                LateAbilitiesSecondPrio($arraycharacters, $arraycharacters2);
                LateAbilitiesThirdPrio($arraycharacters, $arraycharacters2);
                LateAbilitiesSpecialPrio($arraycharacters, $arraycharacters2);
                LateGameCalculation($arraycharacters, $arraycharacters2, $TotalScore);
                $TotalScore->TotalScoreCheck();
                $team_1_final_score = $TotalScore->Team1Score;
                $team_2_final_score = $TotalScore->Team2Score;
        } else {
                $team_1_final_score = $TotalScore->Team1Score;
                $team_2_final_score = $TotalScore->Team2Score;
                print "ДАМЫ И ГОСПОДА)) СО СЧЁТОМ 2-0 ОППОНЕНТОВ АННИГИЛИРОВАЛИ К ХУЯМ СОБАЧЬИМ КОМАНДА - " . $TotalScore->WhoIsWinning($arraycharacters, $arraycharacters2); 
        }

/*--------------------------- Конец третьей стдии ---------------------------*/

$top_a_1_3 = $arraycharacters[0]->attack_points;
$top_d_1_3 = $arraycharacters[0]->defence_points;
$jungle_a_1_3 = $arraycharacters[1]->attack_points;
$jungle_d_1_3 = $arraycharacters[1]->defence_points;
$middle_a_1_3 = $arraycharacters[2]->attack_points;
$middle_d_1_3 = $arraycharacters[2]->defence_points;
$carry_a_1_3 = $arraycharacters[3]->attack_points;
$carry_d_1_3 = $arraycharacters[3]->defence_points;
$support_a_1_3 = $arraycharacters[4]->attack_points;
$support_d_1_3 = $arraycharacters[4]->defence_points;

$top_a_2_3 = $arraycharacters2[0]->attack_points;
$top_d_2_3 = $arraycharacters2[0]->defence_points;
$jungle_a_2_3 = $arraycharacters2[1]->attack_points;
$jungle_d_2_3 = $arraycharacters2[1]->defence_points;
$middle_a_2_3 = $arraycharacters2[2]->attack_points;
$middle_d_2_3 = $arraycharacters2[2]->defence_points;
$carry_a_2_3 = $arraycharacters2[3]->attack_points;
$carry_d_2_3 = $arraycharacters2[3]->defence_points;
$support_a_2_3 = $arraycharacters2[4]->attack_points;
$support_d_2_3 = $arraycharacters2[4]->defence_points;

if ($TotalScore->LateStageCheck()) { // Проверка на 2-0
    for ($i = 1; $i <= sizeof($arraycharacters); $i++) {
        $summ_a_1_3 = bcadd($summ_a_1_3, $arraycharacters[$i - 1]->attack_points, 15);
        $summ_d_1_3 = bcadd($summ_d_1_3, $arraycharacters[$i - 1]->defence_points, 15);
        
        $summ_a_2_3 = bcadd($summ_a_2_3, $arraycharacters2[$i - 1]->attack_points, 15);
        $summ_d_2_3 = bcadd($summ_d_2_3, $arraycharacters2[$i - 1]->defence_points, 15);
        }
} 

/*--------------------------- Конец матча ---------------------------*/


$staff_1 = mysqli_query($connect, "SELECT * FROM `staff` WHERE `user_id` = '$team_1_id'");
$staff_1 = mysqli_fetch_assoc($staff_1);
$staff_1 = array_values($staff_1);
$coach_1 = $staff_1[1];
$press_1 = $staff_1[2];

$staff_2 = mysqli_query($connect, "SELECT * FROM `staff` WHERE `user_id` = '$team_2_id'");
$staff_2 = mysqli_fetch_assoc($staff_2);
$staff_2 = array_values($staff_1);
$coach_2 = $staff_2[1];
$press_2 = $staff_2[2];


$trainer_coef_1 = 0;
$trainer_coef_2 = 0;

for ($i = 0; $i < $coach_1; $i++)
{
    $trainer_coef_1 += 5;
}
for ($i = 0; $i < $coach_2; $i++)
{
    $trainer_coef_2 += 5;
}


$win_1 = false;
$win_2 = false;
$games_summ = $TotalScore->Team1Score + $TotalScore->Team2Score;

$exp_1 = 0;
$exp_2 = 0;

$hero_exp_1 = 0;
$hero_exp_2 = 0;

$sub_1 = 0;
$sub_2 = 0;

for($i = 0; $i < $games_summ; $i++)
{
    $exp_1 += 25;
    $exp_2 += 25;

    $hero_exp_1 += 0.5;
    $hero_exp_2 += 0.5;
    if($TotalScore->Team1Score != 0)
    {
        $exp_1 += 75;
        $hero_exp_1 += 0.5;
        $sub_1 += 1;
        if($TotalScore->Team1Score == 2)
        {
            $win_1 = true;
            $sub_1 += 1;
        }
        $TotalScore->Team1Score -= 1;
    }
    if($TotalScore->Team2Score != 0)
    {
        $exp_2 += 75;
        $hero_exp_2 += 0.5;
        $sub_2 += 1;
        if($TotalScore->Team2Score == 2)
        {
            $win_2 = true;
            $sub_2 += 1;
        }
        $TotalScore->Team2Score -= 1;
    }
}

$moral_1 = 0;
$moral_2 = 0;
$phys_1 = 0;
$phys_2 = 0;

for($i = 0; $i < $games_summ; $i++)
{
    $phys_1 += 5;
}
$phys_2 = $phys_1;

if($win_1 == true)
{
    if($games_summ > 2)
    {
        $moral_1 += 20;
        $moral_2 -= 30;
    }
    $moral_1 += 10;
    $moral_2 -= 20;
}
else
{
    if($games_summ > 2)
    {
        $moral_2 += 20;
        $moral_1 -= 30;
    }
    $moral_2 += 10;
    $moral_1 -= 20;
}

for ($i = 1; $i <= 10; $i++)
{
    if($i <= 5)
    {
        ${"pl_phys_$i"} = $phys_1 * (1 - (${"gm_player_info_$i"}[8] / 100));
        ${"pl_moral_$i"} = $moral_1 * (1 - (${"gm_player_info_$i"}[14] / 100));
    }
    else
    {
        ${"pl_phys_$i"} = $phys_2 * (1 - (${"gm_player_info_$i"}[8] / 100));
        ${"pl_moral_$i"} = $moral_2 * (1 - (${"gm_player_info_$i"}[14] / 100));
    }
}

/*
$pl_phys_1;
$pl_moral_1;

$pl_phys_2;
$pl_moral_2;

$pl_phys_3;
$pl_moral_3;

$pl_phys_4;
$pl_moral_4;

$pl_phys_5;
$pl_moral_5;

$pl_phys_6;
$pl_moral_6;

$pl_phys_7;
$pl_moral_7;

$pl_phys_8;
$pl_moral_8;

$pl_phys_9;
$pl_moral_9;

$pl_phys_10;
$pl_moral_10;
*/

// 3 героя максимум на сигнатурки.

/*
за стадию + 0.5 не зависимо от исхода
за победу в стадии + 0.5 сверху.

2-0 (1-5 - 1.5 опыта, 6-10 - 1 опыта) 
2-1 (1-5 - 2.5 опыта, 6-10 - 2 опыта) 

1-2 (1-5 - 2 опыта, 6-10 - 2.5 опыта) 
0-2 (1-5 - 1 опыта, 6-10 - 1.5 опыта) 

здесь опыт для героев

-----------------------------------
за стадию + 25 не зависимо от исхода
за победу в стадии + 75 сверху.

2-0 (1-5 - 200 опыта, 6-10 - 50 опыта) 
2-1 (1-5 - 225 опыта, 6-10 - 150 опыта) 

1-2 (1-5 - 150 опыта, 6-10 - 225 опыта) 
0-2 (1-5 - 50 опыта, 6-10 - 200 опыта) 

здесь опыт для игрков
---------------------------------------

за стадию - 5% не зависимо от исхода к физ готовности

за победу/поражение в матче +5/-10
за победу/поражение в 3 стадии на весь матч +5/-5

2-0 (1-5 +5 опыта, 6-10 -10 опыта) 
2-1 (1-5 +10  опыта, 6-10 -15 опыта) 

1-2 (1-5 -15  опыта, 6-10 +10  опыта) 
0-2 (1-5 -10 опыта, 6-10 +5  опыта) 

---------------------------------------

за победу в стадии + 1
за победу в матче + 1 сверху

2-0  +3 +0
2-1  +2 +1

1-2  +1 +2
0-2  +0 +3

здесь подписота
*/

$exp_1 *= 1 + ($trainer_coef_1 / 100);
$exp_2 *= 1 + ($trainer_coef_2 / 100);

$sub_1 += ($win_1 == true) ? $press_1 : 0;
$sub_2 += ($win_2 == true) ? $press_2 : 0;

// id талнта игрока - 7.

$player_1_exp = $exp_1 * $gm_player_info_1[8];
$player_2_exp = $exp_1 * $gm_player_info_2[8];
$player_3_exp = $exp_1 * $gm_player_info_3[8];
$player_4_exp = $exp_1 * $gm_player_info_4[8];
$player_5_exp = $exp_1 * $gm_player_info_5[8];

$player_6_exp = $exp_2 * $gm_player_info_6[8];
$player_7_exp = $exp_2 * $gm_player_info_7[8];
$player_8_exp = $exp_2 * $gm_player_info_8[8];
$player_9_exp = $exp_2 * $gm_player_info_9[8];
$player_10_exp = $exp_2 * $gm_player_info_10[8];

$player_hero_1_exp = $hero_exp_1;
$player_hero_2_exp = $hero_exp_1;
$player_hero_3_exp = $hero_exp_1;
$player_hero_4_exp = $hero_exp_1;
$player_hero_5_exp = $hero_exp_1;

$player_hero_6_exp = $hero_exp_2;
$player_hero_7_exp = $hero_exp_2;
$player_hero_8_exp = $hero_exp_2;
$player_hero_9_exp = $hero_exp_2;
$player_hero_10_exp = $hero_exp_2;

$avg_power_team_1 = 100;
$avg_power_five_1 = 50;

$avg_power_team_2 = 200;
$avg_power_five_2 = 75;


// money (деньги) - просто по количеству зрителей

// ---------------------------------------------------------- Функции ---------------------------------------------------------------------------------------//

function PlayersDataConvertation($PlayerData, $MasteryStatus)
{
    $ArrayIDs = [9, 10, 11, 12, 13, 15, 16, 17, 18];
    $check1 = 0;
    $ArrayToMatch = array();
    for ($i = 0; $i < sizeof($PlayerData); $i++)
    {
        if($i == $ArrayIDs[$check1]) {
            array_push($ArrayToMatch, $PlayerData[$i]);
            if ($check1 < 8) {
                $check1 += 1;
            } else {
            break;
        }
        }
    }
    array_push($ArrayToMatch, $PlayerData[sizeof($PlayerData) - 1]);
    if ($MasteryStatus == 1)
    {
        array_push($ArrayToMatch, true);
    }
    else
    {
        array_push($ArrayToMatch, false);
    }
    return $ArrayToMatch;
}

function CaptainArrayCreator($PlayerData, $captain)
{
    $boolarray = array();
    for ($i = 0; $i < 5; $i++)
    {
        if($PlayerData[0] == $captain)
        {
            $boolarray[$i] = true;
        }
        else
        {
            $boolarray[$i] = false;
        }
    }
    return $boolarray;
}

function CharacterDataConvertation($CharacterData)
{
    array_splice($CharacterData, 5, 0, 1);
    unset($CharacterData[0]);
    $CharacterData = array_values($CharacterData);
    return $CharacterData;
}

function MoralAndPhysImpact($teamArray, $i, $player) // Использовать внутри цикла
{
    $Moralcoef = $player[21] / 100;
    $Physcoef = $player[20] / 100;
    for ($j = 0; $j < 9; $j++)
    {
        if($j <= 4)
        {
            $teamArray[$i][$j] = $teamArray[$i][$j] * $Physcoef;
        }
        if($j > 4)
        {
            $teamArray[$i][$j] = $teamArray[$i][$j] * $Moralcoef;
        }
    }
    return $teamArray[$i];
}

/* ———————————No нормального кода?———————————
                ———————————No ООП??———————————————————————
                ⠀⣞⢽⢪⢣⢣⢣⢫⡺⡵⣝⡮⣗⢷⢽⢽⢽⣮⡷⡽⣜⣜⢮⢺⣜⢷⢽⢝⡽⣝
                ⠸⡸⠜⠕⠕⠁⢁⢇⢏⢽⢺⣪⡳⡝⣎⣏⢯⢞⡿⣟⣷⣳⢯⡷⣽⢽⢯⣳⣫⠇
                ⠀⠀⢀⢀⢄⢬⢪⡪⡎⣆⡈⠚⠜⠕⠇⠗⠝⢕⢯⢫⣞⣯⣿⣻⡽⣏⢗⣗⠏⠀
                ⠀⠪⡪⡪⣪⢪⢺⢸⢢⢓⢆⢤⢀⠀⠀⠀⠀⠈⢊⢞⡾⣿⡯⣏⢮⠷⠁⠀⠀
                ⠀⠀⠀⠈⠊⠆⡃⠕⢕⢇⢇⢇⢇⢇⢏⢎⢎⢆⢄⠀⢑⣽⣿⢝⠲⠉⠀⠀⠀⠀
                ⠀⠀⠀⠀⠀⡿⠂⠠⠀⡇⢇⠕⢈⣀⠀⠁⠡⠣⡣⡫⣂⣿⠯⢪⠰⠂⠀⠀⠀⠀
                ⠀⠀⠀⠀⡦⡙⡂⢀⢤⢣⠣⡈⣾⡃⠠⠄⠀⡄⢱⣌⣶⢏⢊⠂⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⠀⢝⡲⣜⡮⡏⢎⢌⢂⠙⠢⠐⢀⢘⢵⣽⣿⡿⠁⠁⠀⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⠀⠨⣺⡺⡕⡕⡱⡑⡆⡕⡅⡕⡜⡼⢽⡻⠏⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⠀⣼⣳⣫⣾⣵⣗⡵⡱⡡⢣⢑⢕⢜⢕⡝⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⣴⣿⣾⣿⣿⣿⡿⡽⡑⢌⠪⡢⡣⣣⡟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⡟⡾⣿⢿⢿⢵⣽⣾⣼⣘⢸⢸⣞⡟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                ⠀⠀⠀⠀⠁⠇⠡⠩⡫⢿⣝⡻⡮⣒⢽⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                —————————————————————————————'; */

function PLayerStatsCalc($teamArray, $captsArr)  // функция расчёта принимает массив команды (игроки по порядку) и массив bool значений, который даёт нам понять кто капитан
{                                                // Расчитывает все изменения в характеристиках игроков от лидерства и конвертацию моральных в технические
    $teamArray = array_values($teamArray);
    $LidersArr = array();
    for ($i = 0; $i < 5; $i++) {
        $LidersArr[$i] = $teamArray[$i][7];
    }
    $buffvalues = Lidership($LidersArr, $captsArr);
    for ($i = 0; $i < 5; $i++) {
        for ($j = 5; $j < 9; $j++) {
            if ($j == 7) {
                continue;
            }
            $teamArray[$i][$j] += $buffvalues[$i];
        }
    }
    $teamArray = MoralToTech($teamArray);
    return $teamArray;
}

// конвертирует характеристики игроков в атаку и защиту персонажей по заранее прописанным формулам.
// Если привязать необходимые коэффициенты к ролям, а роли к классам, то будет гораздо лучше, то что написано ниже работает на индексировании.
// Проклятая функция... Зато работает...
function CharacterConvert($order, $players)
{
    $checkArr = array();
    for ($i = 0; $i < sizeof($order); $i++) {
        array_push($checkArr, $order[$i][1] == $i + 1);
    }
    for ($i = 0; $i < sizeof($order); $i++) // еба...
    {
        $atkIndex = ($checkArr[$i] == $i + 1) ? 5 : 7;
        $defIndex = ($checkArr[$i] == $i + 1) ? 6 : 8;
        $atkIndexDel = ($checkArr[$i] != $i + 1) ? 5 : 7;
        $defIndexDel = ($checkArr[$i] != $i + 1) ? 6 : 8;

        $player = $players[$i];
        $character = $order[$i];
        if ($i == 0) {
            $character[$atkIndex] += ($player[1] * 0.05) + ($player[3] * 0.1);
            $character[$defIndex] += ($player[0] * 0.05) + ($player[3] * 0.1);
            unset($character[$atkIndexDel]);
            unset($character[$defIndexDel]);
            $character = array_values($character);
            $order[$i] = $character;
            continue;
        }
        if ($i == 1) {
            $character[$atkIndex] += ($player[1] * 0.05) + ($player[3] * 0.05);
            $character[$defIndex] += ($player[0] * 0.05) + ($player[3] * 0.05);
            unset($character[$atkIndexDel]);
            unset($character[$defIndexDel]);
            $character = array_values($character);
            $order[$i] = $character;
            continue;
        }
        if ($i == 2 || $i == 3) {
            $character[$atkIndex] += ($player[1] * 0.05) + ($player[3] * 0.05);
            $character[$defIndex] += ($player[0] * 0.1) + ($player[3] * 0.05);
            unset($character[$atkIndexDel]);
            unset($character[$defIndexDel]);
            $character = array_values($character);
            $order[$i] = $character;
            continue;
        }
        if ($i == 4) {
            $character[$atkIndex] += ($player[1] * 0.1) + ($player[3] * 0.05);
            $character[$defIndex] += ($player[0] * 0.05) + ($player[3] * 0.05);
            unset($character[$atkIndexDel]);
            unset($character[$defIndexDel]);
            $character = array_values($character);
            $order[$i] = $character;
            continue;
        }
    }
    return $order;
}

function TeamDefenition($teamArray, $charactersArray, $teamName) // Определяет название команды для каждого персонажа;
{
    $check = $teamArray[0][9];
    for ($i = 0; $i < sizeof($teamArray); $i++) {
        if ($teamArray[$i][9] == $check) {
            $charactersArray[$i][4] = $teamName;
        }
    }
    return $charactersArray;
}

function addLastHit($arraycharacters, $players)  // Добавляет значение характеристики игрока "добивание" к массиву значений персонажа;
{
    for ($i = 0; $i < sizeof($arraycharacters); $i++) {
        array_push($arraycharacters[$i], $players[$i][4]);
    }
    return $arraycharacters;
}

function MapVisionBuff($arraycharacters, $players)      // Конвертация характеристики "Видение карты" игрков в атаку и защиту выбранных им персонажей по прописанной формуле;
{
    $summ = 0;
    $check = 1;
    $temp0 = 0;
    $temp1 = 0;
    $temp2 = 0;
    $temp3 = 0;
    $temp4 = 0;

    for ($i = 0; $i < sizeof($players); $i++) {
        if ($i != $check) {
            ${"temp$i"} = $players[$i][2] * 0.01;
            continue;
        }
        ${"temp$i"} = $players[$i][2] * 0.04;
    }
    for ($k = 0; $k < 5; $k++) {
        $summ += ${"temp$k"};
    }
    for ($j = 0; $j < 5; $j++) {
        $tempsumm = $summ;
        $tempsumm -= ${"temp$j"};
        $temparr[$j] = $tempsumm;
    }

    for ($i = 0; $i < sizeof($arraycharacters); $i++) {
        $arraycharacters[$i][5] += $temparr[$i];
        $arraycharacters[$i][6] += $temparr[$i];
    }

    $arraycharacters = addLastHit($arraycharacters, $players);
    for ($i = 0; $i < sizeof($arraycharacters); $i++) {
        array_push($arraycharacters[$i], $players[$i][10]);
    }
    return $arraycharacters;
}

function Lidership($arrayPlayers, $arrayCapitan)  // Метод расчёта значений, которых надо добавить игрокам чтобы получить бафф от лидерства. 
{                                                 // На вход получаем массив со значениями лидерства каждого игрока, и массив с bool значениями капитана
    $arrayCapitan = array_values($arrayCapitan);
    $temparr = array();                           // Значения возвращаются в том порядке, в котором находятся игроки. 
    $check = 0;                                   // Привязка к позиции даёт нам возможность правильно раскидать нужные значения баффов нужным игркоам
    $summ = 0;
    $tempsumm = 0;
    $temp0 = 0;
    $temp1 = 0;
    $temp2 = 0;
    $temp3 = 0;
    $temp4 = 0;

    for ($i = 0; $i < 5; $i++) {
        if ($arrayCapitan[$i] == true)   // За $arrayCapitan[$i] мы принимаем позицию игрока и проверяем его bool флаг капитана на true или false
        {
            $check = $i;
        } else {
            continue;
        }
    }
    for ($i = 0; $i < sizeof($arrayPlayers); $i++) {
        if ($i != $check) {
            ${"temp$i"} = $arrayPlayers[$i] * 0.01;
            continue;
        }
        ${"temp$i"} = $arrayPlayers[$i] * 0.04;
    }
    for ($k = 0; $k < 5; $k++) {
        $summ += ${"temp$k"};
    }
    for ($j = 0; $j < 5; $j++) {
        $tempsumm = $summ;
        $tempsumm -= ${"temp$j"};
        $temparr[$j] = $tempsumm;
    }
    return $temparr;
}

function MoralToTech($TEAMarray) // Конвертирует моральные характеристики в технические по соответствующим формулам
{
    for ($i = 0; $i < sizeof($TEAMarray); $i++) {
        $TEAMarray[$i][3] += $TEAMarray[$i][5] * 0.01;

        $TEAMarray[$i][1] += $TEAMarray[$i][6] * 0.01;

        $TEAMarray[$i][0] += $TEAMarray[$i][8] * 0.01;
    }
    return $TEAMarray;
}

function CoeffConvert($Coeff) {
    $Coeff = bcmul(bcsub($Coeff, 1, 15), 100, 15);
    return $Coeff;
}































// --------------
function GenofGenTal()  // Просто генератор рандомных характеристик игрокам, позже можно будет убрать за ненадобностью, ибо данные будем дёргать из БД.
{
    $massiv = ArrayGen();
    $summ = 0;
    while (true) {
        $summ = array_sum($massiv);
        if ($summ >= 72 && $summ <= 100)
            return $massiv;
        else {
            $summ = 0;
            $massiv = ArrayGen();
            continue;
        }
    }
}


function ArrayGen()    // генератор характеристик игрокам, но жутко не оптимизирован (имеется ввиду тот генератор что выше.), можно сделать лучше
{
    $arr = array();
    for ($i = 0; $i < 9; $i++) {
        $arr[$i] = mt_rand(8, 12);
    }
    return $arr;
}
// ----------

?>