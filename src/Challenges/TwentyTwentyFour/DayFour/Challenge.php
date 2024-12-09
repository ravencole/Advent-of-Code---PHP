<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DayFour;

use Raven\AocPhp\Challenges\ChallengeBase;

class Challenge extends ChallengeBase
{

    protected array $grid = [];

    public function __construct()
    {
        $this->test_mode = false;

        parent::__construct();

        $this->grid = array_map(function($line) {
            return str_split(trim($line));
        }, explode("\n", $this->input));

        $this->padGrid(4);
    }

    public function partOne(): mixed
    {
        $result = 0;

        for($i = 0; $i < count($this->grid); $i++) {
            $row = $this->grid[$i];

            for($ii = 0; $ii < count($row); $ii++) {
                $point = $this->grid[$i][$ii];

                if($point === 'X') {
                    $result += $this->searchGridFromPoint($i, $ii);
                }
            }
        }

        return $result;
    }

    public function searchGridFromPoint(int $row, int $col): int
    {
        return array_sum([
            $this->searchNorth($row, $col),
            $this->searchNorthEast($row, $col),
            $this->searchEast($row, $col),
            $this->searchSouthEast($row, $col),
            $this->searchSouth($row, $col),
            $this->searchSouthWest($row, $col),
            $this->searchWest($row, $col),
            $this->searchNorthWest($row, $col),
        ]);
    }

    public function searchNorthWest(int $row, int $col): int
    {
        $m = $this->grid[$row - 1][$col - 1];
        $a = $this->grid[$row - 2][$col - 2];
        $s = $this->grid[$row - 3][$col - 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchSouthWest(int $row, int $col): int
    {
        $m = $this->grid[$row + 1][$col - 1];
        $a = $this->grid[$row + 2][$col - 2];
        $s = $this->grid[$row + 3][$col - 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchWest(int $row, int $col): int
    {
        $m = $this->grid[$row][$col - 1];
        $a = $this->grid[$row][$col - 2];
        $s = $this->grid[$row][$col - 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchSouthEast(int $row, int $col): int
    {
        $m = $this->grid[$row + 1][$col + 1];
        $a = $this->grid[$row + 2][$col + 2];
        $s = $this->grid[$row + 3][$col + 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchNorthEast(int $row, int $col): int
    {
        $m = $this->grid[$row - 1][$col + 1];
        $a = $this->grid[$row - 2][$col + 2];
        $s = $this->grid[$row - 3][$col + 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchEast(int $row, int $col): int
    {
        $m = $this->grid[$row][$col + 1];
        $a = $this->grid[$row][$col + 2];
        $s = $this->grid[$row][$col + 3];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchSouth(int $row, int $col): int
    {
        $m = $this->grid[$row + 1][$col];
        $a = $this->grid[$row + 2][$col];
        $s = $this->grid[$row + 3][$col];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function searchNorth(int $row, int $col): int
    {
        $m = $this->grid[$row - 1][$col];
        $a = $this->grid[$row - 2][$col];
        $s = $this->grid[$row - 3][$col];

        if(
               $m === 'M'
            && $a === 'A'
            && $s === 'S'
        ) {
            return 1;
        }

        return 0;
    }

    public function padGrid(int $amt): void
    {
        $grid = array_map(function($row) {
            return [
                '.',
                '.',
                '.',
                ...$row,
                '.',
                '.',
                '.',
            ];
        }, $this->grid);

        $blank_row = array_map(fn() => '.', $grid[0]);

        $this->grid = [
            $blank_row,
            $blank_row,
            $blank_row,
            ...$grid,
            $blank_row,
            $blank_row,
            $blank_row,
        ];
    }

    public function dumpGrid(): void
    {
        $output = join("\n", array_map(function($row) {
            return join('', $row);
        }, $this->grid));

        dd($output);
    }

    public function partTwo(): mixed
    {
        $results = 0;

        for($i = 0; $i < count($this->grid); $i++) {
            for($ii = 0; $ii < count($this->grid[0]); $ii++) {
                if($this->grid[$i][$ii] === 'A') {
                    $results += $this->findMASFromPoint($i, $ii);
                }
            }
        }

        return $results;
    }

    public function findMASFromPoint(int $row, int $col): int
    {
        $tr = $this->grid[$row + 1][$col - 1];
        $tl = $this->grid[$row - 1][$col - 1];
        $br = $this->grid[$row + 1][$col + 1];
        $bl = $this->grid[$row - 1][$col + 1];

        return intval((
                   $tl . $br === 'MS'
                || $br . $tl === 'MS'
            ) && (
                   $tr . $bl === 'MS'
                || $bl . $tr === 'MS'
            ));
    }
}