<?php

namespace Raven\AocPhp\Challenges;

class ChallengeService
{
    public static function generateClassName(int $year, int $day): string
    {
        $year_name = match($year) {
            2024 => 'TwentyTwentyFour'
        };

        $day_name = match($day) {
            1  => 'One',
            2  => 'Two',
            3  => 'Three',
            4  => 'Four',
            5  => 'Five',
            6  => 'Six',
            7  => 'Seven',
            8  => 'Eight',
            9  => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            21 => 'TwentyOne',
            22 => 'TwentyTwo',
            23 => 'TwentyThree',
            24 => 'TwentyFour',
            25 => 'TwentyFive',
        };

        return "\\Raven\\AocPhp\\Challenges\\{$year_name}\\Day{$day_name}\\Challenge";
    }
}