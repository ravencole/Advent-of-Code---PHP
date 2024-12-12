<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayEight;

use Raven\AocPhp\Challenges\ChallengeBase;

class Challenge extends ChallengeBase
{
    public function __construct()
    {
        $this->test_mode = true;

        parent::__construct();
    }

    public function partOne(): mixed
    {
        // key => array locations of antennas
        // Foreach antenna create a rise over run to all of the other frequency antennas
        // rise 1 above top antenna, sink 1 below lower antenna
        // if either of these do not have another type of antenna already placed, mark the spot
        // return number of marked spots

        $grid = array_map( function( $row ) {
            return str_split( trim( $row ) );
        }, explode( "\n", trim( $this->input ) ) );

        $ants = [];

        for( $i = 0; $i < count( $grid ); $i++ ) {
            for( $ii = 0; $ii < count( $grid[0] ); $ii++ ) {
                if( $grid[$i][$ii] !== '.' ) {
                    $key = $grid[$i][$ii];
                    if(! isset($ants[$key])) {
                        $ants[$key] = [];
                    }

                    $ants[$key][] = [$i, $ii];
                }
            }
        }

        foreach($ants as $key => $values) {
            $perms = $this->genUniqueTuples($values);

            foreach($perms as $perm) {
                [
                    $x1, $y1
                ] = $perm[0];

                [
                    $x2, $y2
                ] = $perm[1];

                $slope = ($y2 - $y1) / ($x2 - $x1);

                $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));

                $dx = $distance / sqrt(1 + pow($slope, 2));
                $dy = $slope * $dx;

            }
        }

        return 'Nil';
    }

    public function partTwo(): mixed
    {
        return 'Nil';
    }

    private function gridToString(array $grid)
    {
        return join("\n", array_map( function($row) {
            return join('', $row);
        }, $grid));
    }

    private function dumpGrid(array $grid)
    {
        dump($this->gridToString($grid));
    }

    private function dieGrid(array $grid)
    {
        dd($this->gridToString($grid));
    }

    private function genUniqueTuples(array $arr)
    {
        $result = [];
        $count = count($arr);

        for($i = 0; $i < $count; $i++) {
            for($ii = $i + 1; $ii < $count; $ii++) {
                $result[] = [$arr[$i], $arr[$ii]];
            }
        }

        return $result;
    }
}