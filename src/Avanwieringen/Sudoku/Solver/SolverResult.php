<?php

namespace Avanwieringen\Sudoku\Solver;

use Avanwieringen\Sudoku\Sudoku;

class SolverResult {    
    
    const SOLVED     = 100;
    const SOLVABLE   = 101;
    const UNSOLVABLE = 200;
    //const INVALID    = 201;
    
    private $result;
    private $sudoku;
   
    public function __construct(Sudoku $s, $result) {
        $this->sudoku = $s;
        $this->result = $result;
    }
    
    /**
     * Gets the Result type
     * @return int Result 
     */
    public function getResult() {
        return $this->result;
    }
    
    /**
     * Gets the Sudoku
     * @return Sudoku Sudoku
     */
    public function getSudoku() {
        return $this->sudoku;
    }
    
}