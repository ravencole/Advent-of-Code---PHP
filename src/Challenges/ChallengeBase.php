<?php

namespace Raven\AocPhp\Challenges;

abstract class ChallengeBase
{
    protected $input;

    protected bool $test_mode = false;

    public function __construct()
    {
        $this->setupInput();
    }

    protected function setupInput(): void
    {
        $ref  = new \ReflectionClass(get_called_class());

        $filename = $this->test_mode ? 'test.txt' : 'input.txt';

        $path = dirname($ref->getFileName()) . "/{$filename}";

        $this->input = file_get_contents($path);
    }

    abstract public function partOne(): mixed;
    abstract public function partTwo(): mixed;
}