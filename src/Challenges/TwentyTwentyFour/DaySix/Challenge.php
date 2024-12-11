<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DaySix;

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
        $grid = array_map(function($row) {
            return str_split(trim($row));
        }, explode("\n", trim($this->input)));

        $grid = $this->padGrid($grid);

        $curr = [null, null];

        for($i = 0; $i < count($grid); $i++) {
            for($ii = 0; $ii < count($grid[0]); $ii++) {
                if($grid[$i][$ii] === '^') {
                    $curr[0] = $i;
                    $curr[1] = $ii;

                    $grid[$i][$ii] = 'N';

                    break 2;
                }
            }
        }

        $first_key = join(':', $curr);
        $visited = [
            $first_key => 1
        ];

        while(true) {
            $dir = $grid[$curr[0]][$curr[1]];

            if($dir === 'N') {
                $next = $grid[$curr[0] - 1][$curr[1]];

                if($next === '.') {
                    $grid[$curr[0]][$curr[1]] = '.';
                    $curr[0]--;
                    $grid[$curr[0]][$curr[1]] = 'N';
                } else if($next === '#') {
                    $grid[$curr[0]][$curr[1]] = 'E';
                } else if ($next === '?') {
                    break;
                }

                $visited[$this->makeKey($curr[0], $curr[1])] = 1;
            } else if ($dir === 'E') {
                $next = $grid[$curr[0]][$curr[1] + 1];

                if($next === '.') {
                    $grid[$curr[0]][$curr[1]] = '.';
                    $curr[1]++;
                    $grid[$curr[0]][$curr[1]] = 'E';
                } else if($next === '#') {
                    $grid[$curr[0]][$curr[1]] = 'S';
                } else if ($next === '?') {
                    break;
                }

                $visited[$this->makeKey($curr[0], $curr[1])] = 1;
            } else if ($dir === 'S') {
                $next = $grid[$curr[0] + 1][$curr[1]];

                if($next === '.') {
                    $grid[$curr[0]][$curr[1]] = '.';
                    $curr[0]++;
                    $grid[$curr[0]][$curr[1]] = 'S';
                } else if($next === '#') {
                    $grid[$curr[0]][$curr[1]] = 'W';
                } else if ($next === '?') {
                    break;
                }

                $visited[$this->makeKey($curr[0], $curr[1])] = 1;
            } else { // 'W'
                $next = $grid[$curr[0]][$curr[1] - 1];

                if($next === '.') {
                    $grid[$curr[0]][$curr[1]] = '.';
                    $curr[1]--;
                    $grid[$curr[0]][$curr[1]] = 'W';
                } else if($next === '#') {
                    $grid[$curr[0]][$curr[1]] = 'N';
                } else if ($next === '?') {
                    break;
                }

                $visited[$this->makeKey($curr[0], $curr[1])] = 1;
            }
        }

        return count(array_keys($visited));
    }

    public function partTwo(): mixed
    {
        $grid = array_map(function($row) {
            return str_split(trim($row));
        }, explode("\n", trim($this->input)));

        $grid = $this->padGrid($grid);

        $start = [null, null];
        $curr  = [null, null];

        for($i = 0; $i < count($grid); $i++) {
            for($ii = 0; $ii < count($grid[0]); $ii++) {
                if($grid[$i][$ii] === '^') {
                    $curr[0] = $i;
                    $curr[1] = $ii;
                    $start = $curr;

                    $grid[$i][$ii] = 'N';

                    break 2;
                }
            }
        }

        $all_grids = $this->makeAllGrids($grid);

        $count = 0;

        foreach($all_grids as $g) {
            $curr = $start;
            $first_key = $this->makeKey2('N', $curr[0], $curr[1]);
            $visited = [
                $first_key => 1
            ];

            while(true) {
                $dir = $g[$curr[0]][$curr[1]];

                if($dir === 'N') {
                    $next = $g[$curr[0] - 1][$curr[1]];

                    if($next === '.') {
                        $g[$curr[0]][$curr[1]] = '.';
                        $curr[0]--;
                        $g[$curr[0]][$curr[1]] = 'N';
                    } else if($next === '#') {
                        $g[$curr[0]][$curr[1]] = 'E';
                        $dir = 'E';
                    } else if ($next === '?') {
                        break;
                    }
                } else if ($dir === 'E') {
                    $next = $g[$curr[0]][$curr[1] + 1];

                    if($next === '.') {
                        $g[$curr[0]][$curr[1]] = '.';
                        $curr[1]++;
                        $g[$curr[0]][$curr[1]] = 'E';
                    } else if($next === '#') {
                        $g[$curr[0]][$curr[1]] = 'S';
                        $dir = 'S';
                    } else if ($next === '?') {
                        break;
                    }
                } else if ($dir === 'S') {
                    $next = $g[$curr[0] + 1][$curr[1]];

                    if($next === '.') {
                        $g[$curr[0]][$curr[1]] = '.';
                        $curr[0]++;
                        $g[$curr[0]][$curr[1]] = 'S';
                    } else if($next === '#') {
                        $g[$curr[0]][$curr[1]] = 'W';
                        $dir = 'W';
                    } else if ($next === '?') {
                        break;
                    }
                } else { // 'W'
                    $next = $g[$curr[0]][$curr[1] - 1];

                    if($next === '.') {
                        $g[$curr[0]][$curr[1]] = '.';
                        $curr[1]--;
                        $g[$curr[0]][$curr[1]] = 'W';
                    } else if($next === '#') {
                        $g[$curr[0]][$curr[1]] = 'N';
                        $dir = 'N';
                    } else if ($next === '?') {
                        break;
                    }
                }

                $key = $this->makeKey2($dir, $curr[0], $curr[1]);

                if(isset($visited[$key])) {
                    $count++;
                    break;
                } else {
                    $visited[$key] = 1;
                }
            }
        }

        return $count;
    }

    private function printGrid(array $grid)
    {
        $dump = join("\n", array_map(function($row) {
            return join('', $row);
        }, $grid));

        dump($dump);
    }

    private function dumpGrid(array $grid)
    {
        $dump = join("\n", array_map(function($row) {
            return join('', $row);
        }, $grid));

        dd($dump);
    }

    private function padGrid(array $grid)
    {
        $grid = array_map(function($row) {
            return [
                '?',
                '?',
                '?',
                ...$row,
                '?',
                '?',
                '?',
            ];
        }, $grid);

        $blank_row = array_map(fn() => '?', $grid[0]);

        return [
            $blank_row,
            $blank_row,
            $blank_row,
            ...$grid,
            $blank_row,
            $blank_row,
            $blank_row,
        ];
    }

    private function makeKey(int $row, int $col): string
    {
        return "$row:$col";
    }

    private function makeKey2(string $dir, int $row, int $col): string
    {
        return "$dir:$row:$col";
    }

    private function makeAllGrids(array $grid): array
    {
        $grids = [];

        for($i = 0; $i < count($grid); $i++) {
            for($ii = 0; $ii < count($grid); $ii++) {
                if($grid[$i][$ii] === '.') {
                    $copy = $grid;
                    $copy[$i][$ii] = '#';

                    $grids[] = $copy;
                }
            }
        }

        return $grids;
    }
}