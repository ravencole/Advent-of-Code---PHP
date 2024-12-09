<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayTwo;

use Raven\AocPhp\Challenges\ChallengeBase;

class Challenge extends ChallengeBase
{

    public function __construct()
    {
        $this->test_mode = false;

        parent::__construct();
    }

    public function partOne(): mixed
    {
        return array_reduce(
            explode("\n", $this->input),
            fn($a, $row) => $this->calc(array_map('intval', explode(" ", $row))) ? $a + 1 : $a,
            0
        );
    }

    public function partTwo(): mixed
    {
        return array_reduce(explode("\n", $this->input), function($a, $row) {
            $row = array_map('intval', explode(" ", $row));

            if($this->calc($row)) {
                return $a + 1;
            }

            for ($i = 0; $i < count($row); $i ++) {
                $copy = $row;
                unset($copy[$i]);

                if ($this->calc(array_values($copy))) {
                    return $a + 1;
                }
            }

            return $a;
        }, 0);
    }

    public function calc(array $row): mixed
    {
        $dir = $row[0] < $row[1] ? 'asc' : 'desc';

        for ($i = 1; $i < count($row); $i ++) {
            $diff = $row[$i] - $row[$i - 1];

            if (abs($diff) < 1 || abs($diff) > 3) {
                return false;
            }

            if(
                   ($diff > 0 && $dir === 'desc')
                || ($diff < 0 && $dir === 'asc')
            ) {
                return false;
            }
        }

        return true;
    }
}