<?php

namespace Avanwieringen\Sudoku\Solver;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;

class Solver {
    
    /**
     * Array of Solver Strategies
     * @var Array 
     */
    private $strategies = array();
    
    /**
     * Construct a solver with a strategy or an array of strategies, executed in that order
     * @param StrategyInterface|Array $strategies 
     */
    public function __construct($strategies = null) {
        if(is_array($strategies)) {
            foreach($strategies as $s) {
                $this->addStrategy($s);
            }
        } elseif($strategies instanceof StrategyInterface) {
            $this->addStrategy($strategies);
        }
    }
    
    /**
     * Add a solverstrategy, executed in that order
     * @param StrategyInterface $s 
     */
    public function addStrategy(StrategyInterface $s) {
        $this->strategies[] = $s;
    }
    
    /**
     * Solve a Sudoku
     * @param Sudoku $s 
     */
    public function solve(Sudoku $s) {
        if(count($this->strategies) == 0) throw new SolverException("No solverstrategies added");
        
    }
}

class SolverException extends \Exception {};