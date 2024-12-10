<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayFive;

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
        [
            $rules, $updates
        ] = explode("---", $this->input);

        $rules = array_map(function($rule) {
            return array_map('intval', explode('|', $rule));
        }, explode("\n", trim($rules)));

        $rules = array_reduce($rules, function($a, $b) {
            if(! isset($a[$b[0]])) {
                $a[$b[0]] = [];
            }

            $a[$b[0]][] = $b[1];

            return $a;
        }, []);

        $updates = array_map(function($update) {
            return array_map('intval', explode(',', $update));
        }, explode("\n", trim($updates)));

        $found = [];

        foreach($updates as $update) {
            $valid = true;

            for($i = 1; $i < count($update); $i++) {
                $one = $update[$i - 1];
                $two = $update[$i];

                if(isset($rules[$one]) && in_array($two, $rules[$one])) {
                    continue;
                } else if(isset($rules[$two]) && in_array($one, $rules[$two])) {
                    $valid = false;
                }
            }

            if(! $valid) {
                $found[] = $update;
            }
        }

        return array_reduce($found, function($a, $b) {
            return $a + $b[intval(floor(count($b) / 2))];
        }, 0);
    }

    public function partTwo(): mixed
    {
        [
            $rules, $updates
        ] = explode("---", $this->input);

        $rules = array_map(function($rule) {
            return array_map('intval', explode('|', $rule));
        }, explode("\n", trim($rules)));

        $rules = array_reduce($rules, function($a, $b) {
            if(! isset($a[$b[0]])) {
                $a[$b[0]] = [];
            }

            $a[$b[0]][] = $b[1];

            return $a;
        }, []);

        $updates = array_map(function($update) {
            return array_map('intval', explode(',', $update));
        }, explode("\n", trim($updates)));

        $found = [];

        foreach($updates as $update) {
            $valid = true;

            for($i = 1; $i < count($update); $i++) {
                $one = $update[$i - 1];
                $two = $update[$i];

                if(isset($rules[$one]) && in_array($two, $rules[$one])) {
                    continue;
                } else if(isset($rules[$two]) && in_array($one, $rules[$two])) {
                    $valid = false;
                }
            }

            if(! $valid) {
                $found[] = $update;
            }
        }

        $found = array_map(function($update) use ($rules) {
            usort($update, function($a, $b) use ($rules) {
                if(isset($rules[$a]) && in_array($b, $rules[$a])) {
                    return -1;
                } else if(isset($rules[$b]) && in_array($a, $rules[$b])) {
                    return 1;
                } else {
                    return 0;
                }
            });

            return $update;
        }, $found);

        return array_reduce($found, function($a, $b) {
            return $a + $b[intval(floor(count($b) / 2))];
        }, 0);
    }
}