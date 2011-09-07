<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;
use Avanwieringen\Sudoku\Sudoku;

interface StrategyInterface {
    
    /**
     * Set the Sudoku of the solver;
     */
    public function setSudoku(Sudoku $s);
    
    /**
     * Perform the next solver step. Returns a Sudoku or false on failure
     * @return mixed;
     */
    public function nextStep();
    
}
