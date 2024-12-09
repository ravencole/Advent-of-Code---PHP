<?php

namespace Raven\AocPhp;

use Raven\AocPhp\Challenges\ChallengeService;
use Raven\AocPhp\Challenges\ChallengeClassNotFoundException;

class Runner
{
    protected array $results = [null, null];

    protected bool $benchmarking = false;

    public function __construct(protected int $year, protected int $day, protected int $part = 0)
    {}

    public function setBenchmarking(bool $value): self
    {
        $this->benchmarking = $value;

        return $this;
    }

    public function run(): self
    {
        $class = $this->getChallengeClassName();

        if(! class_exists($class)) {
            throw new ChallengeClassNotFoundException();
        }

        $challenge = new $class();

        if($this->part !== 2) {
            $this->results[0] = $challenge->partOne();
        }

        if($this->part !== 1) {
            $this->results[1] = $challenge->partTwo();
        }

        return $this;
    }

    public function getResults(): array
    {
        return array_filter($this->results, fn($v) => ! is_null($v));
    }

    private function getChallengeClassName(): string
    {
        return ChallengeService::generateClassName($this->year, $this->day);
    }
}