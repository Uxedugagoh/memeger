<?php

class TotalScore
{
    public int $Team1Score;
    public int $Team2Score;

    public int $Stage;

    function __construct($a, $b)
    {
        $this->Team1Score = $a;
        $this->Team2Score = $b;
        $this->Stage = 0;
    }

    function TotalScoreCheck()
    {
        //print "Дамы и господа, на данный момент общий счёт команд: $this->Team1Score vs $this->Team2Score";
        return;
    }

    function LateStageCheck()
    {
        if ($this->Stage == 2)
        {
            if($this->Team1Score == $this->Team2Score)
            {
                return true;
            }
            else
                return false;
        }
        else
        {
            print ("Error: We are not in a Mid Game Stage.");
        }
    }

    function WhoIsWinning($TeamArray1, $TeamArray2)
    {
        if($this->Team1Score > $this->Team2Score)
        {
            return $TeamArray1[0]->TeamName;
        }
        else
        {
            return $TeamArray2[0]->TeamName;
        }
    }
}

class TeamStats
{
    public $SumAtk;
    public $SumDef;

    function __construct()
    {
        $this->SumAtk = 0;
        $this->SumDef = 0;
    }

    function AddToSumm ($character)
    {
        $this->SumAtk = bcadd($this->SumAtk, $character->attack_points, 15);
        $this->SumDef = bcadd($this->SumDef, $character->defence_points, 15);
    }
}

class Character 
{
    public string $Name;
    public int $role;
    public int $position;
    public float $attack_ratio;
    public float $defence_ratio;

    public string $TeamName;
    
    public float $attack_points;
    public float $defence_points;

    public float $Last_hit;
    public bool $Mastery;

    public float $EarlyStageCoeff;
    public float $MidGameFarm;

    public bool $EarlyPassiveStatus = true;
    public bool $MidPassiveStatus = true;
    public bool $LatePassiveStatus = true;

    public int $EarlyPassivePrio = 0; // Способности, отключающие способности оппоненту по линии - 1
    public int $MidPassivePrio = 0; // Способности, отключающие способности конкретному персонажу - 2
    public int $LatePassivePrio = 0; // Способности, влияющие на какие либо статы - 3
                                    // Способности, влияющие на какие либо статы мультипликативно после всех расчётов - 4
    public bool $EarlyCalc = false;
    public bool $MidCalc = false;
    public bool $LateCalc = false;
    
    function __construct($character, $i)
    {
        $this->Name = $character[0];
        $this->role = $character[1];
        $this->position = $i;
        $this->attack_ratio = $character[2];
        $this->defence_ratio = $character[3];

        $this->TeamName = $character[4];

        $this->attack_points = $character[5];
        $this->defence_points = $character[6];
        
        $this->Last_hit = $character[7];
        $this->Mastery = $character[8];
        
    }

    //--------------- Механика на отключение способностей ---------//

    function EarlyAbilityDisable($EnemyTeamArray)
    {
        $EnemyTeamArray[$this->position - 1]->EarlyPassiveStatus = false;
    }

    function MidAbilityDisable($EnemyTeamArray)
    {
        $EnemyTeamArray[$this->position - 1]->MidPassiveStatus = false;
    }

    function LateAbilityDisable($EnemyTeamArray)
    {
        $EnemyTeamArray[$this->position - 1]->LatePassiveStatus = false;
    }
    
    //--------------- Механика на отключение способностей ---------//

    //--------------- СПЕЦИАЛЬНЫЕ МЕХАНИКИ -----------------------//
    //--------------- СПЕЦИАЛЬНЫЕ МЕХАНИКИ -----------------------//

    //-------- Эффекты механик оказывающие влияние на себя -------//
    function SelfAttackBuffInt($n)
    {
        $this->attack_points = bcadd($this->attack_points, $n, 15);;
    }

    function SelfAttackBuffFloat($n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15);
        $this->attack_points = bcmul($this->attack_points, $n, 15);
    }

    function SelfDefenceBuffInt($n)
    {
        $this->defence_points += $n;
    }

    function SelfDefenceBuffFloat($n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15);
        $this->defence_points = bcmul($this->defence_points, $n, 15);
    }

    function SelfAttackDebuffInt($n)
    {
        $this->attack_points = $this->attack_points - $n;
    }

    function SelfDefenceDebuffInt($n)
    {
        $this->defence_points = $this->defence_points - $n;
    }

    function SelfFarmBuffFloat($n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15);
        $this->MidGameFarm = bcmul($this->MidGameFarm, $n, 15);
    }

    function SelfFarmBuffInt($n)
    {
        $this->MidGameFarm = bcadd($this->MidGameFarm, $n, 15);
    }

    function SelfFarmDebuffFloat($n) // Уменьшаем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcsub(1, bcdiv($n, 100, 15), 15);
        $this->MidGameFarm = bcmul($this->MidGameFarm, $n, 15);
    }

    function SelfLastHitBuffInt($n) //
    {
        $this->Last_hit = bcadd($this->Last_hit, $n, 15);
    }

    function SelfLastHitBuffFloat($n)
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15);
        $this->Last_hit = bcmul($this->Last_hit, $n, 15);
    }

    function SelfLastHitDebuffFloat($n)
    {
        $n = bcsub(1, bcdiv($n, 100, 15), 15);
        $this->Last_hit = bcmul($this->Last_hit, $n, 15);
    }
    //-------- Эффекты механик оказывающие влияние на себя -------//


    //-------- Эффекты механик оказывающие влияние на конкретного персонажа-------//
    function SendAttackBuffToInt($TeamArray, $i, $n)
    {
        $TeamArray[$i]->attack_points += $n;
    }

    function SendAttackDebuffToInt($TeamArray, $i, $n)
    {
        $TeamArray[$i]->attack_points = bcsub($TeamArray[$i]->attack_points, $n, 15);
    }

    function SendDefenceBuffToInt($TeamArray, $i, $n)
    {
        $TeamArray[$i]->defence_points += $n;
    }

    function SendDefenceDebuffToInt($TeamArray, $i, $n)
    {
        $TeamArray[$i]->defence_points = bcsub($TeamArray[$i]->defence_points, $n, 15);
    }

    function SendLastHitBuffToFloat($TeamArray, $i, $n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = 1 + ($n / 100);
        $TeamArray[$i]->Last_hit *= $n; // нерпавильно
    }

    function SendFarmDebuffToFloat($TeamArray, $i, $n) // Уменьшаем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcsub(1, bcdiv($n, 100, 15), 15);
        $TeamArray[$i]->MidGameFarm = bcmul($TeamArray[$i]->MidGameFarm, $n, 15);
    }

    function SendFarmBuffToFloat($TeamArray, $i, $n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15); // 1 + ($n / 100);
        $TeamArray[$i]->MidGameFarm = bcmul($TeamArray[$i]->MidGameFarm, $n, 15);
    }
    //-------- Эффекты механик оказывающие влияние на конкретного персонажа -------//
    





    //-------- Эффекты механик оказывающие массовое влияние на выбранную команду -------//
    function MassAttackBuffInt($TeamArray, $n)
    {
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            if($this->position == $i + 1)
                continue;
            $TeamArray[$i]->attack_points += $n;
        }
    }
    
    function MassDefenceBuffInt($TeamArray, $n)
    {
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            if($this->position == $i + 1)
                continue;
            $TeamArray[$i]->defence_points = bcadd($TeamArray[$i]->defence_points, $n, 15);
        }
    }

    function MassFarmBuffToFloat($TeamArray, $n) // Увеличиваем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcadd(1, bcdiv($n, 100, 15), 15); // 1 + ($n / 100);
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            if($this->position == $i + 1)
                continue;
            $TeamArray[$i]->MidGameFarm = bcmul($TeamArray[$i]->MidGameFarm, $n, 15);
        }
    }

    function MassFarmDebuffToFloat($TeamArray, $n) // Уменьшаем фарм в процентах, на вход принимаем число от 1 до 100.
    {
        $n = bcsub(1, bcdiv($n, 100, 15), 15);
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            $TeamArray[$i]->MidGameFarm = bcmul($TeamArray[$i]->MidGameFarm, $n, 15);
        }
    }

    function MassAttackDebuffInt($TeamArray, $n)
    {
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            $TeamArray[$i]->attack_points -= $n;
        }
    }
    
    function MassDefenceDebuffInt($TeamArray, $n)
    {
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            $TeamArray[$i]->defence_points -= $n;
        }
    }

    function MassDefenceDebuffFloat($TeamArray, $n)
    {
        $n = bcsub(1, bcdiv($n, 100, 15), 15);
        for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
        {
            $TeamArray[$i]->defence_points = bcmul($TeamArray[$i]->defence_points, $n, 15);
        }
    }
    //-------- Эффекты механик оказывающие массовое влияние на выбранную команду -------//

    function ShowAllParameters()
    {
        echo "Игрок $this->position из команды $this->TeamName играет за $this->Name на позиции $this->position. Характеристики:\nРоль героя: $this->role, Распределение атаки и защиты в лейте: $this->attack_ratio к $this->defence_ratio, Атака: $this->attack_points, Защита: $this->defence_points, Показатель ласт хита: $this->Last_hit. Мастерство: $this->Mastery. Коэффициент победности на линии: $this->EarlyStageCoeff. Ёрли GAYм фарм: $this->MidGameFarm.  Название класса: ";echo get_class($this);
    }

    function ShowParameter($string)
    {
        echo "Игрок $this->position из команды $this->TeamName. $string параметр: " . $this->$string;
    }
}



/* ========================== ОТДЕЛЬНЫЕ ПЕРСОНАЖИ ===================== */

class Gornn extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
            $this->SelfDefenceBuffInt(10);
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if(bccomp($this->EarlyStageCoeff, $EnemyTeam[$this->position - 1]->EarlyStageCoeff, 15) == 1)
        {
            $this->SelfAttackBuffInt(5);
            $this->SelfDefenceBuffInt(5);
        }
    }
}

class Grace extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(5);
            $this->SelfDefenceBuffInt(5);
        }
        $this->SelfAttackBuffInt(10);
        $this->SelfDefenceBuffInt(10);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmBuffFloat(20);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(10);
        $this->SelfDefenceBuffInt(10);
    }
}

class Furiel extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 14;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(15);
            $this->SelfDefenceBuffInt(20);
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmBuffFloat(20);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffFloat(100);
        $this->SelfDefenceBuffFloat(100);
    }
}

class Rangwald extends Character
{
    public $RangwaldCoef;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 1;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
        $this->RangwaldCoef = 150;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->RangwaldCoef = 200;
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $EnemyTeam[$this->position - 1]->EarlyPassiveStatus = false;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmBuffFloat($this->RangwaldCoef);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Sikaria extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 1;
        $this->LatePassivePrio = 4;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfDefenceBuffInt(20);
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfDefenceBuffInt(20);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfDefenceDebuffInt(20);
        }
        if ($this->EarlyPassiveStatus == true)
        {
            $this->SelfDefenceDebuffInt(20);
        }
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $EnemyTeam[$this->position - 1]->MidPassiveStatus = false;
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->MassDefenceBuffInt($AllyTeam, 5);
        $this->SelfDefenceBuffInt(5);
    }
}

class Hikari extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 4;
        $this->LatePassivePrio = 3;
    }
    
    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
            $this->SelfDefenceBuffInt(10);
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(10);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        if(bccomp($this->EarlyStageCoeff, $EnemyTeam[$this->position - 1]->EarlyStageCoeff, 15) == 1)
        {
            $this->SelfFarmBuffFloat(10);
        }
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Agatha extends Character
{
    public $AgathaCoeff;
    public $BaseAtk;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 3;
        $this->BaseAtk = $this->attack_points;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->BaseAtk = 0;
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $AtkDiff = bcsub($this->BaseAtk, $EnemyTeam[$this->position - 1]->attack_points, 15);
        if($AtkDiff < 0)
        {
            $AtkDiff = abs($AtkDiff);
            $this->SelfFarmBuffFloat($AtkDiff);
            return;
        }
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(40);
        $this->SelfDefenceBuffInt(40);
        if($this->position == 5)
        {
            $AllyTeam[0]->SelfAttackBuffInt(40);
            $AllyTeam[0]->SelfDefenceBuffInt(40);
            return;
        }
        $AllyTeam[$this->position]->SelfAttackBuffInt(40);
        $AllyTeam[$this->position]->SelfDefenceBuffInt(40);
    }
}

class Isabella extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 7;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfDefenceBuffInt(20);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SendFarmDebuffToFloat($EnemyTeam, $this->position - 1, 15);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SendAttackDebuffToInt($EnemyTeam, $this->position - 1, 15);
        $this->SendDefenceDebuffToInt($EnemyTeam, $this->position - 1, 15);
    }
}

class Slither extends Character
{
    public $VictimPosition;
    public $VictimPrevDef;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 11;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->MidPassiveStatus = false;
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if ($this->position == 2)
        {
            if($this->VictimPosition == 3)
            {
                $this->VictimPrevDef = bcsub($EnemyTeam[3]->defence_points, $EnemyTeam[4]->defence_points, 15);
            }
            else
            {
                $this->VictimPrevDef = $EnemyTeam[$this->VictimPosition]->defence_points;
            }
            $EnemyTeam[$this->VictimPosition]->defence_points = 0;
        }
        else
        {
            if($this->position == 4)
            {
                $this->VictimPrevDef = bcsub($EnemyTeam[3]->defence_points, $EnemyTeam[4]->defence_points, 15);
            }
            else
            {
                $this->VictimPrevDef = $EnemyTeam[$this->position - 1]->defence_points;
            }
            $EnemyTeam[$this->position - 1]->defence_points = 0;
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->position == 2)
        {
            $EnemyTeam[$this->VictimPosition]->defence_points = $this->VictimPrevDef;
        }
        else
        {
            $EnemyTeam[$this->position - 1]->defence_points = $this->VictimPrevDef;
        }
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmDebuffFloat(5);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Skalaa extends Character
{
    public $BaseAtk;
    public $BaseDef;
    public $AllyHitChanse;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 10;
        $this->BaseDef = $this->defence_points;
        $this->BaseAtk = $this->attack_points;
        $this->AllyHitChanse = 50;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if ($this->position == 2)
        {
            $this->SelfAttackDebuffInt(80);
            $this->SelfDefenceDebuffInt(80);
        }
        else
        {
            $this->SelfAttackDebuffInt(20);
            $this->SelfDefenceDebuffInt(20);
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        $this->defence_points = $this->BaseDef;
        $this->attack_points = $this->BaseAtk;
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmBuffFloat(25);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->AllyHitChanse = 35;
        }
        $randomMoment = mt_rand(1, 100);
        if ($randomMoment <= $this->AllyHitChanse)
        {
            if($this->position == 5)
            {
                $AllyTeam[0]->defence_points = bcsub($AllyTeam[0], $this->attack_points, 15);
                return;
            }
            $AllyTeam[$this->position]->defence_points = bcsub($AllyTeam[$this->position]->defence_points, $this->attack_points, 15);
            echo "СКАЛА СЛОМАЛА ЕБЛО ТВОЕМУ МИДЕРУ)))))))))))))";
            return;
        }
        $this->attack_points = bcmul($this->attack_points, 2, 15);
    }
}

class Luther extends Character
{
    public $LutherCoeff;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 8;
        $this->LutherCoeff = 0.8;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(15);
        $this->SelfDefenceBuffInt(15);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->MassFarmBuffToFloat($AllyTeam, 15);
        $this->SelfFarmBuffFloat(15);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->LutherCoeff = 0.7;
        }
        if($this->position == 5)
        {
            $EnemyTeam[0]->defence_points = bcmul($EnemyTeam[0]->defence_points, $this->LutherCoeff, 15);
            return;
        }
        $EnemyTeam[$this->position]->defence_points = bcmul($EnemyTeam[$this->position]->defence_points, $this->LutherCoeff, 15);
    }
}

class Richard extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 8;
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
        }
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(10);
        $this->SelfDefenceBuffInt(20);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->MassFarmDebuffToFloat($EnemyTeam, 5);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Firoon extends Character
{
    public $BaseAtk;
    public $BaseDef;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 3;
        $this->BaseDef = $this->defence_points;
        $this->BaseAtk = $this->attack_points;
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
            $this->SelfDefenceBuffInt(10);
        }
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackDebuffInt(30);
        $this->SelfDefenceDebuffInt(20);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $AtkDiff = bcsub($this->attack_points, $EnemyTeam[$this->position - 1]->attack_points, 15);
        if($AtkDiff > 0)
        {
            $this->SelfFarmBuffFloat($AtkDiff);
        }
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackDebuffInt(10);
        $this->SelfDefenceDebuffInt(10);
    }

}

class Haytham extends Character
{
    public string $OpponentsName;
    public $Opponent;
    public $MimicArray;

    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 7;
        $this->LatePassivePrio = 1;
    }

    function MimicArrayFill($Array)
    {
        $Array = array();
        array_push($Array, $this->Name);
        array_push($Array, $this->role);
        array_push($Array, $this->attack_ratio);
        array_push($Array, $this->defence_ratio);
        array_push($Array, $this->TeamName);
        array_push($Array, $this->attack_points);
        array_push($Array, $this->defence_points);
        array_push($Array, $this->Last_hit);
        array_push($Array, $this->Mastery);
        $Array = array_values($Array);
        return $Array;
    }

    function CopyToObj($Object)
    {
        $Object->Name = $this->Name;
        $Object->role = $this->role;
        $Object->position = $this->position;
        $Object->attack_ratio = $this->attack_ratio;
        $Object->defence_ratio = $this->defence_ratio;

        $Object->TeamName = $this->TeamName;
        
        $Object->attack_points = $this->attack_points;
        $Object->defence_points = $this->defence_points;

        $Object->Last_hit = $this->Last_hit;
        $Object->Mastery = $this->Mastery;

        $Object->EarlyStageCoeff = $this->EarlyStageCoeff;
        $Object->MidGameFarm = $this->MidGameFarm;

        $Object->EarlyPassiveStatus = $this->EarlyPassiveStatus = true;
        $Object->MidPassiveStatus = $this->MidPassiveStatus = true;
        $Object->LatePassiveStatus = $this->LatePassiveStatus = true;

        $Object->EarlyPassivePrio = $this->EarlyPassivePrio = 0; 
        $Object->MidPassivePrio = $this->MidPassivePrio = 0; 
        $Object->LatePassivePrio = $this->LatePassivePrio = 0; 

        $Object->MidCalc = $this->MidCalc = false;
        $Object->LateCalc = $this->LateCalc = false;

        return $Object;
    }
    
    function CopyToObj2($Object)
    {
        $this->Name = $Object->Name;
        $this->role = $Object->role;
        $this->position = $Object->position;
        $this->attack_ratio = $Object->attack_ratio;
        $this->defence_ratio = $Object->defence_ratio;

        $this->TeamName = $Object->TeamName;
        
        $this->attack_points = $Object->attack_points;
        $this->defence_points = $Object->defence_points;

        $this->Last_hit = $Object->Last_hit;
        $this->Mastery = $Object->Mastery;

        $this->EarlyStageCoeff = $Object->EarlyStageCoeff;
        $this->MidGameFarm = $Object->MidGameFarm;

        $this->EarlyPassiveStatus = $Object->EarlyPassiveStatus;
        $this->MidPassiveStatus = $Object->MidPassiveStatus;
        $this->LatePassiveStatus = $Object->LatePassiveStatus;

        $this->EarlyPassivePrio = $Object->EarlyPassivePrio; 
        $this->MidPassivePrio = $Object->MidPassivePrio; 
        $this->LatePassivePrio = $Object->LatePassivePrio; 

        $this->MidCalc = $Object->MidCalc;
        $this->LateCalc = $Object->LateCalc;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        $this->LatePassivePrio = $EnemyTeam[$this->position - 1]->LatePassivePrio;
        $this->MimicArray = $this->MimicArrayFill($this->MimicArray);
        $this->MimicArray[0] = $this->Name;
        $this->OpponentsName = $EnemyTeam[$this->position - 1]->Name;
        $this->Opponent = new $this->OpponentsName($this->MimicArray, $this->position);
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(round(($EnemyTeam[$this->position - 1]->attack_points * 0.2), 0, PHP_ROUND_HALF_UP));
        $this->SelfDefenceBuffInt(round(($EnemyTeam[$this->position - 1]->defence_points * 0.2), 0, PHP_ROUND_HALF_UP));
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SelfFarmBuffInt(round(($EnemyTeam[$this->position - 1]->MidGameFarm * 0.2), 0, PHP_ROUND_HALF_UP));
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->Opponent = $this->CopyToObj($this->Opponent);
            $this->Opponent->LateGameImpact($AllyTeam, $EnemyTeam);
            $this->CopyToObj2($this->Opponent);
        }
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
    }

}

class Missandea extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 1;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 9;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $EnemyTeam[$this->position - 1]->EarlyPassiveStatus = false;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->SelfFarmBuffFloat(40);
            return;
        }
        $this->SelfFarmBuffFloat(30);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if( $EnemyTeam[$this->position - 1]->defence_points > 0)
        {
            $EnemyTeam[$this->position - 1]->defence_points = 0;
            return;
        }
    }

}

class Dissa extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 9;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->EarlyCalc = true;
        $EnemyTeam[$this->position - 1]->EarlyCalc = true;
        if($this->Mastery == true)
        {
            $this->EarlyStageCoeff = bcadd(1, bcdiv($this->defence_points, 100, 15), 15);
            $EnemyTeam[$this->position - 1]->EarlyStageCoeff = bcadd(1, bcdiv( bcsub($EnemyTeam[$this->position - 1]->defence_points, bcmul($this->attack_points, 0.3, 15), 15), 100, 15), 15);
            return;
        }
        $this->EarlyStageCoeff = bcadd(1, bcdiv($this->defence_points, 100, 15), 15);
        $EnemyTeam[$this->position - 1]->EarlyStageCoeff = bcadd(1, bcdiv($EnemyTeam[$this->position - 1]->defence_points, 100, 15), 15);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $Coeff = $EnemyTeam[$this->position - 1]->Last_hit;
        $this->SelfFarmBuffFloat($Coeff);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Flamis extends Character
{
    public $FlamisEarlyAttack;
    public $FlamisCoeff = 0.5;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 9;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 9;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            $this->FlamisEarlyAttack = $this->attack_points;
            return;
        }
        $this->attack_points = bcmul($this->attack_points, 1.45, 15);
        $this->FlamisEarlyAttack = $this->attack_points;
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->FlamisCoeff = 0.6;
        }
        $this->attack_points = bcadd($this->attack_points, bcmul($this->attack_points, $this->FlamisCoeff, 15), 15);
    }
}

class Imrich extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 7;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 5;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $EnemyTeam[$this->position - 1]->attack_points = bcsub($EnemyTeam[$this->position - 1]->attack_points, 10, 15);
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->MassFarmDebuffToFloat($EnemyTeam, 10);
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $ImrichCoef = 0.2;
        if($this->Mastery == true)
        {
            $ImrichCoef = 0.3;
        }
        for($i = 0; $i < sizeof($AllyTeam) - 1; $i++)
        {
            if($i == $this->position - 1)
                continue;
            $this->attack_points = bcadd($this->attack_points, bcmul($AllyTeam[$i]->attack_points, $ImrichCoef, 15), 15);
            $this->defence_points = bcadd($this->defence_points, bcmul($AllyTeam[$i]->defence_points, $ImrichCoef, 15), 15);
        }
    }
}

class Solis extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 12;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->EarlyCalc = true;
        $this->EarlyStageCoeff = bcadd(1, bcdiv($this->defence_points, 100, 15), 15); // Механика божественного щита
    }
    function MidGameImpact()
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        if($this->EarlyPassiveStatus == false)
        {
            $this->SelfFarmBuffFloat(50);
            return;
        }
        $this->SelfFarmBuffFloat(20);
    }
    function LateGameImpact()
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if($this->Mastery == true)
        {
            $this->attack_ratio += 0.1;
            $this->defence_ratio += 0.1;
        }
        $this->attack_ratio += 0.8;
        $this->defence_ratio += 1.2;
    }
}

class Rixorr extends Character
{
    public float $RixorrBaseAttack;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->RixorrBaseAttack = $this->attack_points;
        $randomMoment = mt_rand(1, 100);
        if ($randomMoment > 41 && $randomMoment < 76)
        {
            $this->attack_points = bcmul($this->attack_points, 2, 15);
        }
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        $this->attack_points = $this->RixorrBaseAttack;
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SendFarmDebuffToFloat($EnemyTeam, $this->position - 1, 10);
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Akhara extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 8;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $SoulFragment = bcmul($EnemyTeam[$this->position - 1]->defence_points, 0.05, 15);
        $EnemyTeam[$this->position - 1]->defence_points = bcsub($EnemyTeam[$this->position - 1]->defence_points, $SoulFragment, 15);
        $this->SelfAttackBuffInt($SoulFragment);
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $SoulPower = 0.5;
        if ($this->Mastery == true)
        {
            $SoulPower = 0.8;
        }
        $this->defence_points = bcadd($this->defence_points, bcmul($this->MidGameFarm, $SoulPower, 15), 15);
        return;
    }
}

class Erlin extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->SelfAttackBuffInt(20);
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $FarmFragment = bcmul($EnemyTeam[$this->position - 1]->MidGameFarm, 0.2, 15);
        if ($this->Mastery == true)
        {
            $FarmFragment = bcmul($EnemyTeam[$this->position - 1]->MidGameFarm, 0.25, 15);
        }
        $EnemyTeam[$this->position - 1]->MidGameFarm = bcsub($EnemyTeam[$this->position - 1]->MidGameFarm, $FarmFragment, 15);
        $this->SelfFarmBuffInt($FarmFragment);
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Kroos extends Character
{
    public $BaseAtk;
    public bool $DefIsMore = false;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 7;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
        $this->BaseAtk = $this->attack_points;
        if ($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(20);
            $this->SelfDefenceBuffInt(20);
        }
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $DefDiff = 0;
        if($EnemyTeam[$this->position - 1]->defence_points >= $this->defence_points)
        {
            $DefDiff = bcsub($EnemyTeam[$this->position - 1]->defence_points, $this->defence_points, 15);
            $this->defence_points = bcadd($this->defence_points, $DefDiff, 15);
            return;
        }
        $this->DefIsMore = true;
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        if(bccomp($this->attack_points, $this->BaseAtk, 15) == 1)
        {
            $BuffValue = bcsub($this->attack_points, $this->BaseAtk, 15);
            $this->SelfFarmBuffFloat($BuffValue);
        }
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if ($this->Mastery == true)
        {
            return;
        }
        if($this->DefIsMore == true)
        {
            $this->SelfAttackBuffInt(20);
            $this->SelfDefenceBuffInt(20);
        }
    }
}

class Kane extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 12;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if($this->defence_points < $EnemyTeam[$this->position - 1]->defence_points)
        {
            $this->EarlyCalc = true;
            $this->EarlyStageCoeff = bcadd(1, bcdiv($this->defence_points, 100, 15), 15);
        }
    }
    
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        if ($this->Mastery == true)
        {
            $this->SelfFarmBuffFloat(10);
            return;
        }
        $this->SelfFarmBuffFloat(5);
    }

    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
    }
}



class Erlindur extends Character
{
    public float $ErlindurDefRegen;

    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 10;
        $this->MidPassivePrio = 6;
        $this->LatePassivePrio = 4;
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
        }
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        $this->ErlindurDefRegen = $EnemyTeam[3]->attack_points;
        return;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SendFarmBuffToFloat($AllyTeam, 3, 25);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->SendDefenceBuffToInt($AllyTeam, 3, $this->ErlindurDefRegen);
    }
}

class Procellae extends Character
{
    public float $ProcellaeBaseDef;

    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 4;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 8;
        if($this->Mastery == true)
        {
            $this->SelfDefenceBuffInt(10);
        }
        $this->ProcellaeBaseDef = $this->defence_points;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->SendFarmDebuffToFloat($EnemyTeam, 3, 20);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->MassDefenceDebuffFloat($EnemyTeam, $this->ProcellaeBaseDef);
    }
}

class Luma extends Character
{
    private Shtuka $Chelik;

    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 3;
        $this->LatePassivePrio = 6;
        $this->Chelik = new Shtuka();
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $this->Chelik->StatsGive($this);
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == true)
        {
            $this->Chelik->StatsBack($this);
        }
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->MidCalc = true;
        $this->MidGameFarm = bcadd($this->MidGameFarm, $this->Last_hit, 15);
        $this->MidGameFarm = bcmul($this->MidGameFarm, 0.1, 15);
        //$this->Chelik->FarmGive($this);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        $this->Chelik->MassBuff($this, $AllyTeam);
    }
}

class Shtuka
{
    public $attack_points = 50;
    public $defence_points = 10;
    public $Farm = 30;
    public $BuffCoeff = 1.03;

    function StatsGive($Luma)
    {
        if($Luma->Mastery == true)
        {
            $this->attack_points += 10;
            $this->defence_points += 10;
        }
        $Luma->attack_points = bcadd($Luma->attack_points, $this->attack_points);
        $Luma->defence_points = bcadd($Luma->defence_points, $this->defence_points);
    }

    function StatsBack($Luma)
    {
        $Luma->attack_points = bcsub($Luma->attack_points, $this->attack_points);
        $Luma->defence_points = bcsub($Luma->defence_points, $this->defence_points);
    }

    function FarmGive($Luma)
    {
        if($Luma->Mastery == true)
        {
             $this->Farm += 10;
        }
        $Luma->SelfFarmBuffInt($this->Farm);
    }

    function MassBuff($Luma, $Team)
    {
        if($Luma->Mastery == true)
        {
            $this->BuffCoeff += 0.02;
        }
        for($i = 0; $i < sizeof($Team) - 1; $i++)
        {
            $Team[$i]->attack_points = bcmul($Team[$i]->attack_points, $this->BuffCoeff, 15);
            $Team[$i]->defence_points = bcmul($Team[$i]->defence_points, $this->BuffCoeff, 15);
        }
    }
}

class Mortt extends Character
{
    public $Coef1 = 90;

    public $Coef21 = 80;
    public $Coef22 = 15;
    public $Coef23 = 5;


    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 1;
        $this->MidPassivePrio = 8;
        $this->LatePassivePrio = 3;
        $this->attack_points = mt_rand(1, 15);
        $this->defence_points = mt_rand(1, 15);
        $this->attack_ratio = mt_rand(1, 100) / 100;
        $this->defence_ratio = 1 - $this->attack_ratio;
        if($this->Mastery == true)
        {
            $this->Coef1 = 95;

            $this->Coef21 = 70;
            $this->Coef22 = 20;
            $this->Coef23 = 10;
        }
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        $randomMoment = mt_rand(1, 100);
        if($randomMoment <= $this->Coef1)
        {
            $EnemyTeam[$this->position - 1]->EarlyPassiveStatus = false;
        }
        else
        {
            $AllyTeam[3]->EarlyPassiveStatus = false;
        }
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $randomMoment = mt_rand(1, 100);
        if($randomMoment <= $this->Coef21)
        {
            $AllyTeam[3]->SelfFarmBuffFloat(20);
        }
        else if($randomMoment > $this->Coef22 && $randomMoment < $this->Coef23)
        {
            $this->MassFarmBuffToFloat($AllyTeam, 7);
            $this->SelfFarmBuffFloat(7);
        }
        else
        {
            $this->MassFarmBuffToFloat($AllyTeam, 5);
            $this->SelfFarmBuffFloat(5);
            $this->MassFarmDebuffToFloat($EnemyTeam, 5);
        }
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

class Arcwindor extends Character
{
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 3;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 9;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $Coeff = 15;
        if($this->Mastery == true)
        {
            $Coeff = 25;
        }
        if($this->position == 1)
        {
            $AllyTeam[4]->SelfFarmBuffFloat($Coeff);
            return;
        }
        $AllyTeam[$this->position - 2]->SelfFarmBuffFloat($Coeff);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->LatePassiveStatus == false)
        {
            return;
        }
        if($this->position == 1)
        {
            $AllyTeam[5]->SumDef = bcadd($AllyTeam[5]->SumDef, $AllyTeam[4]->defence_points, 15);
            $AllyTeam[5]->SumAtk = bcadd($AllyTeam[5]->SumAtk, $AllyTeam[4]->attack_points, 15);
            $AllyTeam[4]->LateCalc = true;
            return;
        }
        $AllyTeam[5]->SumDef = bcadd($AllyTeam[5]->SumDef, $AllyTeam[$this->position - 2]->defence_points, 15);
        $AllyTeam[5]->SumAtk = bcadd($AllyTeam[5]->SumAtk, $AllyTeam[$this->position - 2]->attack_points, 15);
        $AllyTeam[$this->position - 2]->LateCalc = true;
    }
}

class Anika extends Character
{
    public $HealCoeff = 0.25;
    public $FarmAuraCoeff = 10;
    public $Healed;
    function PrioDefenition()
    {
        $this->EarlyPassivePrio = 10;
        $this->MidPassivePrio = 5;
        $this->LatePassivePrio = 3;
    }

    function EarlyGameImpact($AllyTeam, $EnemyTeam)
    {
        if($this->Mastery == true)
        {
            $this->SelfAttackBuffInt(10);
            $this->SelfDefenceBuffInt(10);
            $this->HealCoeff = 0.35;
            $this->FarmAuraCoeff = 15;
        }
        if ($this->EarlyPassiveStatus == false)
        {
            return;
        }
        if($this->position == 1)
        {
            $this->Healed = bcmul($EnemyTeam[4]->attack_points, $this->HealCoeff, 15);
            $AllyTeam[4]->defence_points = bcadd($AllyTeam[4]->defence_points, $this->Healed, 15);
            return;
        }
        $this->Healed = bcmul($EnemyTeam[$this->position - 2]->attack_points, $this->HealCoeff, 15);
        $AllyTeam[$this->position - 2]->defence_points = bcadd($AllyTeam[$this->position - 2]->defence_points, $this->Healed, 15);
        return;
    }
    function MidGameImpact($AllyTeam, $EnemyTeam)
    {
        if ($this->EarlyPassiveStatus == true)
        {
            if($this->position == 1)
            {
                $AllyTeam[4]->defence_points = bcsub($AllyTeam[4]->defence_points, $this->Healed, 15);
                return;
            }
            $AllyTeam[$this->position - 2]->defence_points = bcsub($AllyTeam[$this->position - 2]->defence_points, $this->Healed, 15);
        }
        if ($this->MidPassiveStatus == false)
        {
            return;
        }
        $this->MassFarmBuffToFloat($AllyTeam, $this->FarmAuraCoeff);
        $this->SelfFarmBuffFloat($this->FarmAuraCoeff);
    }
    function LateGameImpact($AllyTeam, $EnemyTeam)
    {
        return;
    }
}

// ============================ ФУНКЦИИ ДЛЯ ГЕНЕРАЦИИ НУЖНЫХ ЗНАЧЕНИЙ И ПРОЧЕГО ==================== //

function TeamGen($TeamArray) // Создаёт массив объектов Character принимая на вход массив массивов с просчитанными значениями персонажей
{
    $ReturnArray = array();
    for($i = 0; $i < sizeof($TeamArray); $i++)
    {
        $characterName = $TeamArray[$i][0];
        $ReturnArray[$i] = new $characterName($TeamArray[$i], $i + 1);
        $ReturnArray[$i]->PrioDefenition();
    }
    $TeamStats = new TeamStats();
    array_push($ReturnArray, $TeamStats);
    return $ReturnArray;
}

function TeamShow($TeamArray) // Вывод значений полей объекта Character
{
    for($i = 0; $i < sizeof($TeamArray) - 1; $i++)
    {
        $TeamArray[$i]->ShowAllParameters();
    }
}






/* ===========================  EARLY GAME ================================*/

function EarlyAbilitiesFirstPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 0; $i < 4; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->EarlyGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->EarlyGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function EarlyAbilitiesSecondPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 4; $i < 6; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->EarlyGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->EarlyGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function EarlyAbilitiesThirdPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 6; $i < 8; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->EarlyGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->EarlyGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function EarlyAbilitiesSpecialPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 8; $i < 15; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->EarlyGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->EarlyPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->EarlyGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function JunglerStatsGive($TeamArray, $atkTo, $defTo)
{
    if(get_class($TeamArray[1]) == 'Slither')
    {
        $TeamArray[1]->VictimPosition = $atkTo;
    }
    $TeamArray[$atkTo]->attack_points += $TeamArray[1]->attack_points;
    $TeamArray[$defTo]->defence_points += $TeamArray[1]->defence_points;
}

function SupportStatsGive($TeamArray)
{
    $TeamArray[3]->attack_points += $TeamArray[4]->attack_points;
    $TeamArray[3]->defence_points += $TeamArray[4]->defence_points;
}

function EarlyStageCalculation($TeamArray1, $TeamArray2)
{
    for($i = 0; $i < sizeof($TeamArray1) - 2; $i++)
    {
        if($i == 1)
        {
            $TeamArray1[$i]->EarlyStageCoeff = 1;
            $TeamArray2[$i]->EarlyStageCoeff = 1;
            continue;
        }
        if($TeamArray1[$i]->EarlyCalc != true)    
        {
            $TeamArray1[$i]->EarlyStageCoeff = bcadd(1, bcdiv( bcsub($TeamArray1[$i]->defence_points, $TeamArray2[$i]->attack_points, 15), 100, 15), 15);
        }
        if($TeamArray2[$i]->EarlyCalc != true)
        {
            $TeamArray2[$i]->EarlyStageCoeff = bcadd(1, bcdiv( bcsub($TeamArray2[$i]->defence_points, $TeamArray1[$i]->attack_points, 15), 100, 15), 15);
        }        
    }
    $TeamArray1[4]->EarlyStageCoeff = $TeamArray1[3]->EarlyStageCoeff;
    $TeamArray2[4]->EarlyStageCoeff = $TeamArray2[3]->EarlyStageCoeff;

    for ($i = 0; $i < sizeof($TeamArray1) - 1; $i++)
    {
        $TeamArray1[$i]->MidGameFarm = bcmul($TeamArray1[$i]->EarlyStageCoeff, $TeamArray1[$i]->Last_hit, 15);
        $TeamArray2[$i]->MidGameFarm = bcmul($TeamArray2[$i]->EarlyStageCoeff, $TeamArray2[$i]->Last_hit, 15);
    }
}

function EarlyGameEnd($TeamArray1, $TeamArray2, $Score, $jungle_a_1, $jungle_d_1, $jungle_a_2, $jungle_d_2)
{
    $summ1 = 0;
    $summ2 = 0;
    for ($i = 0; $i < sizeof($TeamArray1) - 1; $i++)
    {
        $summ1 += $TeamArray1[$i]->EarlyStageCoeff;
        $summ2 += $TeamArray2[$i]->EarlyStageCoeff;
    }
    if ($summ1 > $summ2)
    {
        $Score->Team1Score += 1;
        $Score->Stage += 1;
    }
    else if ($summ2 > $summ1)
    {
        $Score->Team2Score += 1;
        $Score->Stage += 1;
    }


    $TeamArray1[$jungle_a_1 - 1]->attack_points -= $TeamArray1[1]->attack_points;
    $TeamArray1[$jungle_d_1 - 1]->defence_points -= $TeamArray1[1]->defence_points;
    $TeamArray2[$jungle_a_2 - 1]->attack_points -= $TeamArray2[1]->attack_points;
    $TeamArray2[$jungle_d_2 - 1]->defence_points -= $TeamArray2[1]->defence_points;

    $TeamArray1[3]->attack_points -= $TeamArray1[4]->attack_points;
    $TeamArray1[3]->defence_points -= $TeamArray1[4]->defence_points;
    $TeamArray2[3]->attack_points -= $TeamArray2[4]->attack_points;
    $TeamArray2[3]->defence_points -= $TeamArray2[4]->defence_points;
}

/* ===========================  EARLY GAME ================================*/






/* ===========================  MID GAME ================================*/

function MidAbilitiesFirstPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 0; $i < 4; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->MidGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->MidGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function MidAbilitiesSecondPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 4; $i < 6; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->MidGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->MidGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function MidAbilitiesThirdPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 6; $i < 8; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->MidGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->MidGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function MidAbilitiesSpecialPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 8; $i < 15; $i++)
    {
        for($j = 0; $j < sizeof($AllyTeam) - 1; $j++)
        {
            if($AllyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $AllyTeam[$j]->MidGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->MidPassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->MidGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}


function MidStageCalculation($TeamArray1, $TeamArray2)
{
    for ($i = 0; $i < sizeof($TeamArray1) - 1; $i++)
    {
        if($TeamArray1[$i]->MidCalc == false)
            $TeamArray1[$i]->MidGameFarm = bcadd($TeamArray1[$i]->MidGameFarm, $TeamArray1[$i]->Last_hit, 15);
        if($TeamArray2[$i]->MidCalc == false)
            $TeamArray2[$i]->MidGameFarm = bcadd($TeamArray2[$i]->MidGameFarm, $TeamArray2[$i]->Last_hit, 15);
    }
    if($TeamArray1[4]->MidCalc == false)
        $TeamArray1[4]->MidGameFarm = bcmul($TeamArray1[4]->MidGameFarm, 0.1, 15);
    if($TeamArray2[4]->MidCalc == false)
        $TeamArray2[4]->MidGameFarm = bcmul($TeamArray2[4]->MidGameFarm, 0.1, 15);
}

function MidStageEnd($TeamArray1, $TeamArray2, $Score)
{
    $summ1 = 0;
    $summ2 = 0;
    for ($i = 0; $i < sizeof($TeamArray1) - 1; $i++)
    {
        $summ1 = bcadd($TeamArray1[$i]->MidGameFarm, $summ1, 15);
        $summ2 = bcadd($TeamArray2[$i]->MidGameFarm, $summ2, 15);
    }
    if (bccomp($summ1, $summ2, 15) == 1)
    {
        $Score->Team1Score += 1;
        $Score->Stage += 1;
    }
    else if (bccomp($summ1, $summ2, 15) == -1)
    {
        $Score->Team2Score += 1;
        $Score->Stage += 1;
    }
}

/* ===========================  MID GAME ================================*/






/* ===========================  LATE GAME ================================*/

function LateAbilitiesFirstPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 0; $i < 4; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $AllyTeam[$j]->LateGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->LateGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function LateAbilitiesSecondPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 4; $i < 6; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $AllyTeam[$j]->LateGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->LateGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function LateAbilitiesThirdPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 6; $i < 8; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $AllyTeam[$j]->LateGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->LateGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function LateAbilitiesSpecialPrio($AllyTeam, $EnemyTeam)
{
    for ($i = 8; $i < 15; $i++)
    {
        for($j = 0; $j < 5; $j++)
        {
            if($AllyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $AllyTeam[$j]->LateGameImpact($AllyTeam, $EnemyTeam);
            }
            if($EnemyTeam[$j]->LatePassivePrio == $i + 1)
            {
                $EnemyTeam[$j]->LateGameImpact($EnemyTeam, $AllyTeam);
            }
        }
    }
}

function FarmConvert($TeamArray)
{
    for ($i = 0; $i < sizeof($TeamArray) - 1; $i++)
    {
        $FarmToStats = bcmul($TeamArray[$i]->MidGameFarm, 0.3, 15);
        $TeamArray[$i]->attack_points = bcadd($TeamArray[$i]->attack_points, bcmul($FarmToStats, $TeamArray[$i]->attack_ratio, 15), 15);
        $TeamArray[$i]->defence_points = bcadd($TeamArray[$i]->defence_points, bcmul($FarmToStats, $TeamArray[$i]->defence_ratio, 15), 15);
    }
}

function LateGameCalculation($TeamArray1, $TeamArray2, $TotalScore)
{ 
    for ($i = 0; $i < sizeof($TeamArray1) - 1; $i++)
    {
        if($TeamArray1[$i]->LateCalc == false)
        {
            $TeamArray1[5]->SumDef = bcadd($TeamArray1[5]->SumDef, $TeamArray1[$i]->defence_points, 15);
            $TeamArray1[5]->SumAtk = bcadd($TeamArray1[5]->SumAtk, $TeamArray1[$i]->attack_points, 15);
        }
        if($TeamArray2[$i]->LateCalc == false)
        {
            $TeamArray2[5]->SumDef = bcadd($TeamArray2[5]->SumDef, $TeamArray2[$i]->defence_points, 15);
            $TeamArray2[5]->SumAtk = bcadd($TeamArray2[5]->SumAtk, $TeamArray2[$i]->attack_points, 15);
        }
    }
    if (bccomp(bcsub($TeamArray1[5]->SumDef, $TeamArray2[5]->SumAtk, 15), bcsub($TeamArray2[5]->SumDef, $TeamArray1[5]->SumAtk, 15), 15) == 1)
    {
        $TotalScore->Team1Score += 1;
    }
    else if (bccomp(bcsub($TeamArray1[5]->SumDef, $TeamArray2[5]->SumAtk, 15), bcsub($TeamArray2[5]->SumDef, $TeamArray1[5]->SumAtk, 15), 15) == -1)
    {
        $TotalScore->Team2Score += 1;
    }
}
/* ===========================  LATE GAME ================================*/
?>
