<?php

namespace Raven\AocPhp;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Exception;
use splitbrain\phpcli\Options;
use Raven\AocPhp\Challenges\ChallengeClassNotFoundException;

class CommandKernel extends CLI
{
    const RUN = 'run';
    const SCAFFOLD = 'scaffold';

    protected function setup(Options $options)
    {
        $options->setHelp('Run yourself an AOC');

        $this->setupRunCommand($options);
        $this->setupScaffoldCommand($options);
    }

    protected function main(Options $options)
    {
        switch($options->getCmd()) {
            case self::RUN:
                $this->runRunCommand($options);
                break;
            case self::SCAFFOLD:
                $this->runScaffoldCommand($options);
                break;
            default:
                throw new Exception('Command not found');
        }
    }

    private function setupRunCommand(Options $options):void
    {
        $options->registerCommand(self::RUN, 'Run a specific AOC challenge');
        $options->registerOption('benchmark', 'Benchmark your solution', 'b', false, self::RUN);
        $options->registerOption('part', 'Run a single part of the challenge', 'p', true, self::RUN);
        $options->registerArgument('year', 'Challenge Year', true, self::RUN);
        $options->registerArgument('day', 'Challenge Day', true, self::RUN);
    }

    private function runRunCommand(Options $options)
    {
        [
            $year, $day
        ] = array_map('intval', $options->getArgs());

        $part = intval($options->getOpt('part', 0));

        $runner = new Runner($year, $day, $part);
        $runner->setBenchmarking($options->getOpt('benchmark'));

        try {
            $runner->run();
        }
        catch(ChallengeClassNotFoundException $err) {
            $this->alert('Challenge class not found');
            $this->fatal($err);
        }
        catch(\Throwable $err) {
            $this->fatal($err);
        }

        foreach($runner->getResults() as $key => $result) {
            if($part === 0) {
                $this->info('Part ' . $key + 1 . ': ' . $result);
            } else {
                $this->info('Part ' . $part . ': ' . $result);
            }
        }
    }

    private function runScaffoldCommand(Options $options)
    {

    }

    private function setupScaffoldCommand(Options $options):void
    {
        $options->registerCommand(self::SCAFFOLD, 'Generate a class for an AOC challenge');
    }
}