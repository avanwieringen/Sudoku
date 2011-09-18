<?php

namespace Avanwieringen\Sudoku\Solver\Event;

use Symfony\Component\EventDispatcher\Event;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;

class IterationDoneEvent extends Event {
    
    private $time;
    
    public function __construct($time) {
        $this->time = $time;
    }
    
    public function getTime() {
        return $this->time;
    }
}