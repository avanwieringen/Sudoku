<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;
use Avanwieringen\Sudoku\Sudoku;

interface StrategyInterface {
    
    /**
     * Perform the next solver step. Returns one or more Sudokus
     * @return Sudoku|array;
     */
    public function solve(Sudoku $s);
    
}
