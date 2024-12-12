<?php

namespace Raven\AocPhp\Challenges\TwentyTwentyFour\DaySeven;

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
        $input = array_map( function( $line ) {
            [
                $target, $values
            ] = explode( ':', $line );

            $values = array_map( 'intval',  explode( " ", trim( $values ) ) );

            return [
                'target' => $target,
                'values' => $values,
            ];
        }, explode( "\n", $this->input ));

        $result = 0;

        foreach( $input as $row ) {
            $hold = [];

            for( $i = 0; $i < count( $row[ 'values' ] ); $i++ ) {
                $curr = $row[ 'values' ][ $i ];

                if( ! count( $hold ) ) {
                    $hold[] = $curr;

                    continue;
                }

                $hold = array_reduce( $hold, function( $a, $b ) use ( $curr ) {
                    $a[] = $b + $curr;
                    $a[] = $b * $curr;

                    return $a;
                }, [] );
            }

            if( in_array( $row[ 'target' ], $hold ) ) {
                $result += $row[ 'target' ];
            }
        }

        return $result;
    }

    public function partTwo(): mixed
    {
        $input = array_map( function( $line ) {
            [
                $target, $values
            ] = explode( ':', $line );

            $values = array_map( 'intval',  explode( " ", trim( $values ) ) );

            return [
                'target' => intval( $target ),
                'values' => $values,
            ];
        }, explode( "\n", $this->input ));

        $result = 0;

        foreach( $input as $key => $row ) {
            $hold = [];

            for( $i = 0; $i < count( $row[ 'values' ] ); $i++ ) {
                $curr = $row[ 'values' ][ $i ];
                $target = $row[ 'target' ];

                if( ! count( $hold ) ) {
                    $hold[] = $curr;

                    continue;
                }

                $hold = array_reduce( $hold, function( $a, $b ) use ( $curr, $target ) {
                    if( $b > $target ) {
                        return $a;
                    }

                    $add = $b + $curr;
                    $mul = $b * $curr;
                    $con = intval( "{$b}{$curr}" );

                    if( $add <= $target ) {
                        $a[] = $add;
                    }

                    if( $mul <= $target ) {
                        $a[] = $mul;
                    }

                    if( $con <= $target ) {
                        $a[] = $con;
                    }

                    return $a;
                }, [] );
            }

            if( in_array( $row[ 'target' ], $hold ) ) {
                $result += $row[ 'target' ];
            }
        }

        return $result;
    }
}