<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;
use Avanwieringen\Sudoku\Sudoku;

interface StrategyInterface {
    
    /**
     * Set the Sudoku of the solver;
     */
    public function setSudoku(Sudoku $s);
    
    /**
     * Perform the next solver step. Returns a an array with the step (row, column, value)
     * @param int The next step chosen, follows from getPossibleSteps
     * @return mixed;
     */
    public function getNextStep($stepChoice);
    
    /**
     * Get the amount of possible steps to be taken
     */
    public function getPossibleSteps();
    
}
