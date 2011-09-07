<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;;
use Avanwieringen\Sudoku\Sudoku;

abstract class AbstractStrategy implements StrategyInterface {
    
    /**
     * Sudoku of the strategy
     * @var Sudoku 
     */
    protected $sudoku;
    
    public function setSudoku(Sudoku $s) {
        $this->sudoku = $s;
    }
    
}
