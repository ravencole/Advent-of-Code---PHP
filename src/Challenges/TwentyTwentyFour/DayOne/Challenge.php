<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayOne;

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
        $input = array_reduce(explode("\n", $this->input), function($a, $b) {
            [
                $left, $right
            ] = preg_split("/\s+/", $b);

            $a[0][] = intval($left);
            $a[1][] = intval($right);

            return $a;
        }, [[], []]);

        $input = array_map(function($list) {
            sort($list);

            return $list;
        }, $input);

        $results = 0;

        for($i = 0; $i < count($input[0]); $i++) {
            $results += abs($input[0][$i] - $input[1][$i]);
        }

        return $results;
    }

    public function partTwo(): mixed
    {
        [
            $left, $right_counts
        ] = array_reduce(explode("\n", $this->input), function($a, $b) {
            [
                $left, $right
            ] = preg_split("/\s+/", $b);
            $right = intval($right);

            $a[0][] = intval($left);

            if(! isset($a[1][$right])) {
                $a[1][$right] = 0;
            }

            $a[1][$right]++;

            return $a;
        }, [[], []]);

        return array_reduce($left, function($a, $b) use ($right_counts) {
            return $a + (isset($right_counts[$b]) ? $right_counts[$b] * $b : 0);
        }, 0);
    }
}