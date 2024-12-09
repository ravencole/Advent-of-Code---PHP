<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayThree;

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
        $results = 0;

        foreach(explode("\n", $this->input) as $line) {
            preg_match_all("/mul\(\d{1,3},\d{1,3}\)/", $line, $matches);

            foreach($matches[0] as $func) {
                preg_match_all("/\d+/", $func, $tmp);

                $results += intval($tmp[0][0]) * intval($tmp[0][1]);
            }
        }

        return $results;
    }

    public function partTwo(): mixed
    {
        $results = 0;

        $do = true;

        foreach(explode("\n", $this->input) as $line) {
            preg_match_all("/mul\(\d{1,3},\d{1,3}\)|do(?:n't)?/", $line, $matches);

            foreach($matches[0] as $func) {
                if($func === 'do' || $func === "don't") {
                    $do = $func === 'do';

                    continue;
                }

                if($do) {
                    preg_match_all("/\d+/", $func, $tmp);

                    $results += intval($tmp[0][0]) * intval($tmp[0][1]);
                }
            }
        }

        return $results;
    }
}