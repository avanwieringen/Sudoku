<?php

namespace Avanwieringen\Sudoku\Solver\Event;

use Symfony\Component\EventDispatcher\Event;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;

class IterationEvent extends Event {
    
    private $sudoku;
    private $level;
    private $strategy;
    
    public function __construct(Sudoku $s, StrategyInterface $strategy, $level = 0) {
        $this->sudoku = $s;
        $this->level  = $level;
        $this->strategy = $strategy;
    }
    
    public function getLevel() {
        return $this->level;
    }
    
    public function getSudoku() {
        return $this->sudoku;
    }
    
    public function getStrategy() {
        return $this->strategy;
    }
    
}